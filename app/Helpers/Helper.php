<?php 
use App\Cart;
function totalCartItems()
{
    if(Auth::check())
    {
        $user_id = Auth::User()->id;
        $totalCartItems = Cart::where('user_id',$user_id)->sum('quantity');
        return $totalCartItems;   
    }
    else
    {
        $session_id = Session::get('session_id');
        $totalCartItems = Cart::where('session_id',$session_id)->sum('quantity');
        return $totalCartItems;
    }

}
?>