@extends(view: 'layouts.auth')

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Create') }} Ticket</span>
                    </div>
                    <div class="card-body bg-white">
                        <form method="POST" action="{{ route('tickets.store') }}"  role="form" enctype="multipart/form-data">
                            @csrf

                            @include('ticket.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
