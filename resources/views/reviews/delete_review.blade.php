@extends('layouts.app')
 
@section('content')
<div class="modal fade" id="deleteReviewsModal{{ $reviews->id }}" tabindex="-1" aria-labelledby="deleteReviewsModalLabel{{ $reviews->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteReviewsModalLabel{{ $reviews->id }}">「{{ $reviews->title }}」を削除してもよろしいですか？</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
            </div>
            <div class="modal-footer">
                <form action="{{ route('reviews.destroy', [$reviews]) }}" method="post">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-danger">削除</button>
                </form>
            </div>
        </div>
    </div>
</div> 
@endsection