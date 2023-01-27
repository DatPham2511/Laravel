@extends('layout')
@section('content')

@section('menu')
    @include('menu')
@endsection
<div class="col-sm-9 padding-right">
					<div class="features_items"><!--features_items-->
						<h2 class="title text-center">Tin tức</h2>
                        <span id="cart_session"></span>


                            @foreach ($post as $key => $pos)
                            <div>

                                        <a  href="{{URL::to('/bai-viet/'.$pos->post_slug)}}">
                                            <img style="float:left;width:30%;padding:5px;height:200px" src="{{URL::to('uploads/post/'.$pos->post_image)}}" alt="" />
                                            <p style="color: #000;padding:5px;font-size:21px;font-weight:bold">{{$pos->post_title}}</p>



                                            </a>

                                            {!!$pos->post_desc!!}


                            </div>
                            <div class="clearfix"></div>
                            <br><br>
                            @endforeach




					</div><!--features_items-->

                    <div class="col-sm-12 text-right text-center-xs">
                        <ul class="pagination pagination-sm m-t-none m-b-none">
                            {{$post->links()}}
                         </ul>
                    </div>

</div>
@endsection

