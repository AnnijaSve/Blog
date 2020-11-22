@extends('layouts.app')
@section('content')
    <div class="container">
        <a href="{{ route('articles.create') }}" class="btn btn-primary btn-sm">
            Create new article
        </a>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Created at</th>
                <th scope="col">Updated at</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($articles as $article)
                <tr>
                    <th scope="row">{{ $article->id }}</th>
                    <td>{{ $article->title }}</td>
                    <td>{{ $article->created_at->format('Y-m-d h:i') }}</td>
                    <td>{{ $article->updated_at->format('Y-m-d h:i') }}</td>
                    <td>
                        <a href="{{ route('articles.edit', $article) }}" class="btn btn-sm btn-warning">
                            Edit
                        </a>
                        <form method="post" action="{{ route('articles.destroy', $article) }}" style="display: inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

@endsection
