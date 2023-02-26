@extends('layouts.app')
 
@section('content')
<div class="modal fade" id="editReviewsModal{{ $reviews->id }}" tabindex="-1" aria-labelledby="editReviewsModalLabel{{ $reviews->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editReviewsModalLabel{{ $reviews->id }}">レビューの編集</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
            </div>
            <form action="{{ route('reviews.update', [$reviews]) }}" method="post">
                @csrf
                @method('patch')  
                <div class="modal-body">
                    <input type="text" name="title" class="form-control m-2" value="{{ $reviews->title }}">
                    <select name="five_star" class="form-control m-2">
                        <option value=0>☆☆☆☆☆</option>
                        <option value=1>★☆☆☆☆</option>
                        <option value=2>★★☆☆☆</option>
                        <option value=3>★★★☆☆</option>
                        <option value=4>★★★★☆</option>
                        <option value=5>★★★★★</option>
                    </select>
                    <textarea name="comment" class="form-control m-2" value="{{ $reviews->comment }}"></textarea>
                    <input type="file" name="img">                                        
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">更新</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection