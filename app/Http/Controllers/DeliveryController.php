<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;
use App\Models\Province;
use App\Models\Wards;
use App\Models\Feeship;
use Auth;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();

class DeliveryController extends Controller
{
    public function AuthLogin(){
        $admin_id = Auth::id();
        if($admin_id){
            return Redirect::to('/dashboard');
        }else{
            return Redirect::to('/admin')->send();
        }
    }
    public function delivery(Request $request){
        $this->AuthLogin();
    	$city = City::get();
    	return view('admin.delivery.add_delivery')->with(compact('city'));
    }
    //chọn tp,qh
    public function select_delivery(Request $request){
        $this->AuthLogin();
    	$data = $request->all();
    	if($data['action']){
    		$output = '';
    		if($data['action']=="city"){
    			$select_province = Province::where('matp',$data['ma_id'])->get();
    				$output.='<option>---Chọn quận huyện---</option>';
    			foreach($select_province as $key => $province){
    				$output.='<option value="'.$province->maqh.'">'.$province->name_quanhuyen.'</option>';
    			}

    		}else{
		        $feeship = Feeship::get();
                $data_xa=array();
                foreach($feeship as $key => $fee){
                    $xaid=$fee->fee_xaid;
                    array_push($data_xa, $xaid);
                }
    			    $select_wards = Wards::where('maqh',$data['ma_id'])->whereNotIn('xaid', $data_xa)->get();
    			    $output.='<option>---Chọn xã phường---</option>';
    			foreach($select_wards as $key => $ward){
    				$output.='<option value="'.$ward->xaid.'">'.$ward->name_xaphuong.'</option>';
    			}

    		}
    		echo $output;
    	}
    }
    //thêm fee
    public function insert_delivery(Request $request){
        $this->AuthLogin();
		$data = $request->all();
		$fee_ship = new Feeship();
		$fee_ship->fee_matp = $data['city'];
		$fee_ship->fee_maqh = $data['province'];
		$fee_ship->fee_xaid = $data['wards'];
		$fee_ship->fee_feeship = $data['fee_ship'];
		$fee_ship->save();
	}
    //hiên thị fee
    public function select_feeship(){
        $this->AuthLogin();
		$feeship = Feeship::orderby('fee_id','DESC')->get();
		$output = '';
		$output .= '<div class="table-responsive">
			<table class="table table-bordered" >
				<thread>
					<tr>
                        <th>STT</th>
						<th>Tên thành phố</th>
						<th>Tên quận huyện</th>
						<th>Tên xã phường</th>
						<th>Phí ship</th>
					</tr>
				</thread>
				<tbody>
				';
                $i=0;
				foreach($feeship as $key => $fee){
                    $i++;
				$output.='
					<tr>
                        <td>'.$i.'</td>
						<td>'.$fee->city->name_city.'</td>
						<td>'.$fee->province->name_quanhuyen.'</td>
						<td>'.$fee->wards->name_xaphuong.'</td>
						<td contenteditable name="money" data-feeship_id="'.$fee->fee_id.'" class="fee_feeship_edit">'.number_format($fee->fee_feeship,0,',','.').' vnđ</td>
					</tr>
					';
				}

				$output.='
				</tbody>
				</table></div>
				';
				echo $output;
	}
    //update tiền
    public function update_delivery(Request $request){
        $this->AuthLogin();

        $feeship_id=$request->feeship_id;
        $fee_value=$request->fee_value;
		$fee_ship = Feeship::find($feeship_id);
		$fee_ship->fee_feeship = $fee_value;
		$fee_ship->save();
	}
}
