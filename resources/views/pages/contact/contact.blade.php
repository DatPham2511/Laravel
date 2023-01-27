@extends('layout')
@section('content')

<div class="col-sm-12 padding-right">
					<div class="features_items"><!--features_items-->
						<h2 class="title text-center">Liên hệ với chúng tôi</h2>
                        <div class="row">
                            @foreach ($contact as $key => $cont)


                            <div class="col-md-12" style="padding-bottom: 10px">
                                <h4 style="font-weight: bold;">Thông tin liên hệ</h4>
                                    {!!$cont->info_contact!!}
                            </div>
                            <div class="col-md-12" >
                                <h4 style="font-weight: bold;">Fanpage:</h4>
                                    {!!$cont->info_fanpage!!}
                            </div>
                            <div class="col-md-12" style="padding-top: 24px">
                                <h4 style="font-weight: bold;">Bản đồ</h4>
                                {!!$cont->info_map!!}
                            </div>
                        </div>
                        @endforeach
					</div>
                    </div>
@endsection
