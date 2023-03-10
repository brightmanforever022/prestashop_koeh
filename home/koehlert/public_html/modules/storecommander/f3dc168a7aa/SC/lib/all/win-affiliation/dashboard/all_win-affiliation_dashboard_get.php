<?php

$id_lang=intval(Tools::getValue('id_lang',0));
$start_month=intval(Tools::getValue('start_month',0));
$start_year=intval(Tools::getValue('start_year',0));
$end_month=intval(Tools::getValue('end_month',0));
$end_year=intval(Tools::getValue('end_year',0));
$id_shop = intval(Tools::getValue("id_shop", "0"));

$return = array("type"=>"error","message"=>_l('Your dates are incorrect. Please check your dates.'));

if(!empty($start_month) && !empty($start_year) && !empty($end_month) && !empty($end_year))
{
	if($end_year."-".$end_month >= $start_year."-".$start_month)
	{
		$html = "";
		$i=0;
		for($y=$start_year; $y<=$end_year; $y++)
		{
			for($m=1; $m<=12; $m++)
			{
				$add = true;
				if($start_year==$y && $m<$start_month)
					$add = false;
				if($end_year==$y && $m>$end_month)
				{
					$add = false;
					break;
				}
				if($add)
				{
					$day_start = $y."-".$m."-01";
					$day_end = $y."-".$m."-".SCI::days_in_month(CAL_GREGORIAN, $m, $y);
					
					/*$current_amount = rand(100, 10000);
					$nb_cmd = rand(1, 20);*/
					$current_amount = 0;
					$nb_cmd = 0;
					$orders = SCAffCommission::GetAffiliatesOrdersByDates($day_start, $day_end, null, $id_shop);
					foreach ($orders as $order)
					{
						if ($order->valid)
						{
							$nb_cmd++;
							$current_amount += $order->total_products;
						}
					}
					$click = SCAffClick::GetNbClickByDate($day_start, $day_end, null, $id_shop);
					$visiteur = SCAffClick::GetNbVisiteurByDate($day_start, $day_end, null, $id_shop);
					$html .= '<tr class="deletable '.(($i>0 && ($i%2))?"edd":"").'">
								<td>'.str_pad($m, 2, "0", STR_PAD_LEFT)."/".$y.'</td>
								<td class="aright">'.number_format($current_amount,2).'</td>
								<td class="aright">'.$click.'</td>
								<td class="aright">'.$visiteur.'</td>
								<td class="aright">'.$nb_cmd.'</td>
								<td class="aright">'.((!empty($visiteur))?number_format($nb_cmd/$visiteur*100):"0").'%</td>
							</tr>';
					$i++;
				}
			}
		}
		$return = array("type"=>"success","message"=>$html);
	}
	else
		$return = array("type"=>"error","message"=>_l('Your dates are incorrect. Please check your dates.'));
}

echo json_encode($return);