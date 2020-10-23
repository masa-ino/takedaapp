foreach($user_list as $user_one){
print($user_one['name']);
print($user_one['id']);
foreach($user_one['times'] as $times){
print($times['time_name']);
foreach($times['subjects'] as $subject_name){
print($subject_name);
}
}
}