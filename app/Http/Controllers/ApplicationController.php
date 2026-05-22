<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Pet;
use App\Models\Category;
use App\Http\Requests\StoreApplicationRequest;
use App\Http\Requests\UpdateApplicationRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ApplicationController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display all applications (Admin only).
     */
    public function index(Request $request): View
    {
        $this->authorize('viewAny', Application::class);

        $query = Application::query()
            ->with(['user', 'pet'])
            ->recentFirst();

        // Search functionality
        if ($request->filled('search')) {
            $query->search($request->get('search'));
        }

        // Filter by status
        $status = $request->get('status');
        if ($status && $status !== 'All') {
            if ($status === 'Active') {
                $query->whereIn('application_status', ['Pending', 'Interview Scheduled']);
            } else {
                $query->byStatus($status);
            }
        } elseif (!$status) {
            // Default to Active
            $query->whereIn('application_status', ['Pending', 'Interview Scheduled']);
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->byCategory($request->get('category'));
        }

        // Filter by date range
        if ($request->filled('start_date') || $request->filled('end_date')) {
            $query->dateRange(
                $request->get('start_date'),
                $request->get('end_date')
            );
        }

        $applications = $query->paginate(15);

        $stats = [
            'total' => Application::count(),
            'pending' => Application::pending()->count(),
            'approved' => Application::approved()->count(),
            'declined' => Application::declined()->count(),
            'interview_scheduled' => Application::interviewScheduled()->count(),
        ];

        $categories = Category::all();

        return view('applications.index', [
            'applications' => $applications,
            'stats' => $stats,
            'categories' => $categories,
            'search' => $request->get('search'),
            'application_status' => $status ?: 'Active',
            'category' => $request->get('category'),
            'startDate' => $request->get('start_date'),
            'endDate' => $request->get('end_date'),
        ]);
    }

    /**
     * Show the form for creating a new adoption application (Adopters only).
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Application::class);

        $pet = null;
        if ($request->has('pet_id')) {
            $pet = Pet::where('id', $request->get('pet_id'))
                ->where('status', 'Available')
                ->firstOrFail();

            // Check if user already has an active application for this pet
            $existingApplication = Application::where('user_id', auth()->id())
                ->where('pet_id', $pet->id)
                ->first();

            if ($existingApplication) {
                return redirect()->route('applications.show', $existingApplication)
                    ->with('info', 'You already have an application for this pet.');
            }
        }

        $pets = Pet::where('status', 'Available')->get();

        return view('applications.create', [
            'pet' => $pet,
            'pets' => $pets,
            'user' => auth()->user(),
        ]);
    }

    /**
     * Store a new adoption application in the database.
     */
    public function store(StoreApplicationRequest $request): RedirectResponse
    {
        $this->authorize('create', Application::class);

        // Check for duplicate active application
        $existingApplication = Application::where('user_id', auth()->id())
            ->where('pet_id', $request->pet_id)
            ->first();

        if ($existingApplication) {
            return back()
                ->with('error', 'You have already submitted an application for this pet. Please wait for admin review.');
        }

        try {
            $application = Application::create([
                'user_id' => auth()->id(),
                'pet_id' => $request->pet_id,
                'adopter_name' => $request->adopter_name,
                'contact_number' => $request->contact_number,
                'address' => $request->address,
                'home_background' => $request->home_background,
                'application_date' => $request->application_date,
                'application_status' => 'Pending',
            ]);

            return redirect()->route('applications.show', $application)
                ->with('success', 'Your adoption application has been submitted successfully! 🎉 We will review it shortly.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'An error occurred while submitting your application. Please try again.')
                ->withInput();
        }
    }

    /**
     * Display the specified application.
     */
    public function show(Application $application): View
    {
        // Check authorization
        if (auth()->user()->isAdmin()) {
            // Admins can view any application
        } elseif (auth()->id() === $application->user_id) {
            // Adopters can only view their own applications
        } else {
            abort(403);
        }

        $application->load(['user', 'pet']);

        return view('applications.show', [
            'application' => $application,
        ]);
    }

    /**
     * Show the form for editing an application (Admin only).
     */
    public function edit(Application $application): View
    {
        $this->authorize('update', $application);

        $application->load(['user', 'pet']);

        return view('applications.edit', [
            'application' => $application,
        ]);
    }

    /**
     * Update the specified application in the database (Admin only).
     */
    public function update(UpdateApplicationRequest $request, Application $application): RedirectResponse
    {
        $this->authorize('update', $application);

        try {
            // ── Lock: once Approved, the status can never be changed again ──
            if ($application->application_status === 'Approved' && $request->has('status')) {
                return back()
                    ->with('error', 'This application has already been approved and its status is now locked.')
                    ->withInput();
            }

            $application->update([
                'application_status' => $request->status ?? $application->application_status,
                'admin_notes'        => $request->admin_notes,
            ]);

            // If approved, update pet status
            if ($request->status === 'Approved') {
                $application->pet->update(['status' => 'Adopted']);
            }

            $statusMessage = match ($request->status ?? $application->application_status) {
                'Approved'           => 'Application approved! 🎉 The pet has been marked as Adopted.',
                'Declined'           => 'Application declined.',
                'Interview Scheduled'=> 'Interview scheduled.',
                default              => 'Application updated.',
            };

            return redirect()->route('applications.show', $application)
                ->with('success', $statusMessage);
        } catch (\Exception $e) {
            return back()
                ->with('error', 'An error occurred while updating the application.')
                ->withInput();
        }
    }

    /**
     * Change application status to "Interview Scheduled" (Admin quick action).
     */
    public function interview(Application $application): RedirectResponse
    {
        $this->authorize('update', $application);

        try {
            $application->update(['application_status' => 'Interview Scheduled']);

            return redirect()->route('applications.show', $application)
                ->with('success', 'Interview scheduled! 📅');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'An error occurred while scheduling the interview.');
        }
    }

    /**
     * Approve an application (Admin quick action).
     */
    public function approve(Application $application): RedirectResponse
    {
        $this->authorize('update', $application);

        try {
            $application->update(['application_status' => 'Approved']);

            // Update pet status to Adopted
            $application->pet->update(['status' => 'Adopted']);

            return redirect()->route('applications.index')
                ->with('success', 'Application approved! 🎉');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'An error occurred while approving the application.');
        }
    }

    /**
     * Decline an application (Admin quick action).
     */
    public function decline(Application $application): RedirectResponse
    {
        $this->authorize('update', $application);

        try {
            $application->update(['application_status' => 'Declined']);

            return redirect()->route('applications.index')
                ->with('success', 'Application declined.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'An error occurred while declining the application.');
        }
    }

    /**
     * Display adopter's own applications.
     */
    public function myApplications(Request $request): View
    {
        $query = Application::where('user_id', auth()->id())
            ->with(['pet'])
            ->recentFirst();

        // Filter by status
        if ($request->filled('status')) {
            $query->byStatus($request->get('status'));
        }

        $applications = $query->paginate(10);

        return view('applications.my-applications', [
            'applications' => $applications,
            'application_status' => $request->get('status'),
        ]);
    }

    /**
     * Display application history/archive (Admin).
     */
    public function history(Request $request): View
    {
        $this->authorize('viewHistory', Application::class);

        $query = Application::query()
            ->with(['user', 'pet'])
            ->whereIn('application_status', ['Approved', 'Declined'])
            ->recentFirst();

        // Filter by status
        if ($request->filled('status')) {
            $query->byStatus($request->get('status'));
        }

        // Filter by date range
        if ($request->filled('start_date') || $request->filled('end_date')) {
            $query->dateRange(
                $request->get('start_date'),
                $request->get('end_date')
            );
        }

        $applications = $query->paginate(15);

        return view('applications.history', [
            'applications' => $applications,
            'application_status' => $request->get('status'),
            'startDate' => $request->get('start_date'),
            'endDate' => $request->get('end_date'),
        ]);
    }

    /**
     * Delete an application (Admin only).
     */
    public function destroy(Application $application): RedirectResponse
    {
        $this->authorize('delete', $application);

        try {
            $petName = $application->pet->name ?? 'Unknown Pet';
            $application->delete();

            return redirect()->route('applications.index')
                ->with('success', "Application for {$petName} has been deleted.");
        } catch (\Exception $e) {
            return back()
                ->with('error', 'An error occurred while deleting the application.');
        }
    }
}
