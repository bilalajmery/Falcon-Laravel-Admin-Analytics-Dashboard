@include('includes.header')

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-sm-12">
            <div class="card text-center shadow border-danger" role="alert" aria-live="assertive">
                <div class="card-header bg-danger text-white">
                    <h4 class="mb-0">Access Denied</h4>
                </div>
                <div class="card-body py-5">
                    <div class="mb-4">
                        <svg class="bi bi-exclamation-circle text-danger" width="64" height="64" fill="currentColor" aria-hidden="true"
                            viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z" />
                            <path
                                d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z" />
                        </svg>
                    </div>
                    <h5 class="card-title text-danger mb-4">{{ $message ?? 'You do not have permission to view this page.' }}</h5>
                    <p class="card-text text-muted mb-4">
                        It seems you lack the necessary access rights to proceed. If you believe this is an error, please contact your administrator
                        for assistance.
                    </p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ route('home') }}" class="btn btn-primary">Return to Dashboard</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('includes.footer')
