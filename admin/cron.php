<?php 

include('header.php'); 

		$ladder = new Ladder($db);
		$list=$ladder->GetLadders();
		
		//print_r($list);
		foreach($list as $key=>$val){
//		print_r($val);
						$ladder=new Ladder($db,$val->id);
		//sending prizes

			if(($val->status!=3)and($val->end_time<time())){
				$prizes=$ladder->GetPrizesInfo();
				

				


				if($ladder->IsTemplate()){
                        				        $ladder->Repeat();
				
				}

				$ladder->Close();
			}

				if($ladder->IsTemplate()){
					
					//echo "template";

				}

		//sending prizes

		}
include('footer.php'); 

?>