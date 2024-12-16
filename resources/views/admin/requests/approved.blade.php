@extends('layouts.admin')

@section('title', __('messages.approved_requests'))

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
                <a class="nav-link" href="{{ route('admin.requests.index') }}">{{ __('messages.pending_requests') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="{{ route('admin.requests.approved') }}">{{ __('messages.approved_requests') }}</a>
            </li>
        </ul>

        @if($approvedRequests->isEmpty())
            <p class="text-center">{{ __('messages.no_approved_requests') }}</p>
        @else
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>{{ __('messages.product_name') }}</th>
                    <th>{{ __('messages.image') }}</th>
                    <th>{{ __('messages.description') }}</th>
                    <th>{{ __('messages.approved_at') }}</th>
                    <th>{{ __('messages.actions') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($approvedRequests as $request)
                    <tr>
                        <td>{{ $request->product_name }}</td>
                        <td>
                            @if($request->image_url)
                                <img src="{{ $request->image_url }}" alt="Image" class="img-thumbnail" style="max-height: 50px;">
                            @endif
                        </td>
                        <td>{{ $request->description }}</td>
                        <td>{{ $request->updated_at->format('d-m-Y H:i') }}</td>
                        <td>
                            <form action="{{ route('admin.requests.update', $request->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="rejected">
                                <button class="btn btn-danger btn-sm" title="{{ __('messages.reject_and_delete') }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
