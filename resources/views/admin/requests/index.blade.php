@extends('layouts.admin')

@section('title', __('messages.product_requests'))

@section('content')
    <div class="container my-5">
        <h1 class="text-center mb-4">{{ __('messages.product_requests') }}</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <ul class="nav nav-tabs mb-4">
            <li class="nav-item">
                <a class="nav-link active" href="#pending" data-bs-toggle="tab">{{ __('messages.pending_requests') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.requests.approved') }}">{{ __('messages.approved_requests') }}</a>
            </li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane fade show active" id="pending">
                @if($requests->isEmpty())
                    <p class="text-center">{{ __('messages.no_requests') }}</p>
                @else
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>{{ __('messages.product_name') }}</th>
                            <th>{{ __('messages.image') }}</th>
                            <th>{{ __('messages.description') }}</th>
                            <th>{{ __('messages.status') }}</th>
                            <th>{{ __('messages.actions') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($requests as $request)
                            <tr>
                                <td>{{ $request->product_name }}</td>
                                <td>
                                    @if($request->image_url)
                                        <img src="{{ $request->image_url }}" alt="Image" class="img-thumbnail" style="max-height: 50px;">
                                    @endif
                                </td>
                                <td>{{ $request->description }}</td>
                                <td>
                                    <span class="badge
                                        {{ $request->status == 'pending' ? 'bg-warning' : ($request->status == 'approved' ? 'bg-success' : 'bg-danger') }}">
                                        {{ ucfirst($request->status) }}
                                    </span>
                                </td>
                                <td>
                                    <form action="{{ route('admin.requests.update', $request->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="approved">
                                        <button class="btn btn-success btn-sm">{{ __('messages.approve') }}</button>
                                    </form>
                                    <form action="{{ route('admin.requests.update', $request->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="rejected">
                                        <button class="btn btn-danger btn-sm">{{ __('messages.reject') }}</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
@endsection
