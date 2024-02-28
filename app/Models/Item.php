<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Item extends Model
{
    protected $table='item';
    protected $fillable=['cat_id','item_name','item_description','item_price','delivery_time'];
    public function variation(){
        return $this->hasMany('App\Models\Variation','item_id','id')->select('variation.id','variation.item_id','variation.variation','variation.product_price','variation.sale_price');
    }
    public function subcategory_info(){
        return $this->hasOne('App\Models\Subcategory','id','subcat_id')->select('subcategories.id','subcategories.subcategory_name','subcategories.slug');
    }
    public function category_info(){
        return $this->hasOne('App\Models\Category','id','cat_id')->select('categories.id','categories.category_name','categories.slug',\DB::raw("CONCAT('".url(env('ASSETSPATHURL').'admin-assets/images/category/')."/', image) AS image_url"));
    }
    public function item_image(){
        return $this->hasOne('App\Models\ItemImages','item_id','id')->select('item_images.id','item_images.image as image_name','item_images.item_id',\DB::raw("CONCAT('".url(env('ASSETSPATHURL').'admin-assets/images/item/')."/', item_images.image) AS image_url"));
    }
    public function item_images(){
        return $this->hasMany('App\Models\ItemImages','item_id','id')->select('item_images.id','item_images.image as image_name','item_images.item_id',\DB::raw("CONCAT('".url(env('ASSETSPATHURL').'admin-assets/images/item/')."/', item_images.image) AS image_url"));
    }
}