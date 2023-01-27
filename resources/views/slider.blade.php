<section id="slider"><!--slider-->
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div id="slider-carousel" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        @php
                         $i = 0;
                         @endphp
                        @foreach($slider as $key)
                            @php
                                $i++;
                            @endphp
                            <li  class="{{ $i==1 ? 'active' : '' }}"></li>
                        @endforeach
                    </ol>

                    <style type="text/css">
                        img.img.img-responsive.img-slider {
                            height: 350px;
                            width:90%;
                        }
                    </style>
                    <div class="carousel-inner">
                    @php
                        $i = 0;
                    @endphp
                    @foreach($slider as $key => $slide)
                        @php
                            $i++;
                        @endphp
                        <div class="item {{$i==1 ? 'active' : '' }}">

                            <div >
                                <img alt="{{$slide->slider_desc}}" src="{{asset('uploads/slider/'.$slide->slider_image)}}"  class="img img-responsive img-slider">

                            </div>
                        </div>
                    @endforeach


                    </div>

                    <a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
                        <i class="fa fa-angle-left"></i>
                    </a>
                    <a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
                        <i class="fa fa-angle-right"></i>
                    </a>
                </div>

            </div>
        </div>
    </div>
</section><!--/slider-->
