@extends('layout')
@section('content')

@section('menu')
    @include('menu')
@endsection
<div class="col-sm-9 padding-right">
					<div class="features_items"><!--features_items-->
						<h2 style="margin: 0 auto 30px;font-weight:bold" class="text-center">{{$post_by_slug->post_title}}</h2>
                        <span id="cart_session"></span>
                            <div>
                                           
                                            {!!$post_by_slug->post_content!!}
                            </div>
					</div><!--features_items-->
</div>
@endsection

