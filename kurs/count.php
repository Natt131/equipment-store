<?php


  function integral($temp) {
       $x_beg = (float)str_replace('pi', pi(), $_POST['x_from']);
$x_end = (float)str_replace('pi', pi(), $_POST['x_to']);
$formul = $_POST['formul'];

$formul = str_replace('^','**',$formul);
$formul = '$result = (' . str_replace('x','$x',$formul) . ');';

$n=-($x_end-$x_beg)/$temp; //step /zamena temp
$arr1=array();
for($i=0; $i<=$temp; $i++){ //step
	$x=$x_beg+$i*$n;
	eval($formul);
	$arr1[]=$result;
}
$sum=0;
for($i=1; $i<=$temp-1; $i++){ //step
	
	$sum+=$arr1[$i];
}


$res=$n/2*($arr1[0]+$arr1[$temp]+2*$sum);//step
  return $res;  }

//начало основной программы
$check=false; //для проверки данных
$x_beg = (float)str_replace('pi', pi(), $_POST['x_from']);
$x_end = (float)str_replace('pi', pi(), $_POST['x_to']);
$formul = $_POST['formul'];
$step = $_POST['step'];


//проверка границ
/*    if ((is_int($x_beg))||(is_int($x_end))) // 	||(is_int($x_beg))
	{
		print ('<p style="color: red">' . 'Ошибка: проверьте правильность введеных границ'. '</p>'); 
	    $check=true;
		exit();
	}
	//проверка формулы
	else {
try
{
	$formul = str_replace('^','**',$formul);
$formul = '$result = (' . str_replace('x','$x',$formul) . ');';
$x=1;
eval($formul);}

catch( Exception $e) {}
finally {
	  $check=true;
	print ('<p style="color: red">' . 'Ошибка: проверьте правильность подинтегральной функции'. '</p>'); 
exit();

}
	}*/

print('form '.$x_beg.' to '.$x_end.' for:'.$formul.' ,by '.$step.'</br></br>');

$temp=10;


//*2 temp //ubran kod
//$temp=$temp*2;

$res11=integral($temp);
$temp=$temp*2;
$res22=integral($temp);
//$res2=$n/2*($arr1[0]+$arr1[$temp]+2*$sum);//step

if($res22-$res11<=$step)

print( 'Результат: '.$res22.'</br></br>');
else {
while ($res22-$res11>$step)
{
	$res11=$res22;
	$temp=$temp*2;
	$res22=integral($temp);

}
	print( 'Результат: '.number_format($res22, 3, '.', ',').'</br></br>');

}




