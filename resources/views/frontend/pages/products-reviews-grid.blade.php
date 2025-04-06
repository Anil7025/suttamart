<div class="col-lg-8">
    <h4 class="mb-30">Please login to write review!</h4>
    <div class="comment-list">
        @foreach($pro_reviews as $row)
        <div class="single-comment justify-content-between d-flex mb-30">
            <div class="user justify-content-between d-flex">
                <div class="thumb text-center">
                    @if ($row->image != '')
                    <img src="{{ asset('uploads/users/'.$row->image)}}" alt="" />
                    @else
                    <img src="{{ asset('admin') }}/images/album_icon.png" alt="" />
                    @endif
                    <a href="#" class="font-heading text-brand">{{$row->name}}</a>
                </div>
                <div class="desc">
                    <div class="d-flex justify-content-between mb-10">
                        <div class="d-flex align-items-center">
                            <span class="font-xs text-muted">{{ date('d F Y', strtotime($row->created_at)) }} </span>
                        </div>
                        <div class="product-rate d-inline-block">
                            <div class="product-rating" style="width: 100%"></div>
                        </div>
                    </div>
                    <p class="mb-10">{{$row->comments}}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="row mt-15">
        <div class="col-lg-12">
            {{ $pro_reviews->links() }}
        </div>
    </div>
</div>