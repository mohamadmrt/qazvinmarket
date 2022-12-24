<?php

    namespace App;

    use App\Http\Controllers\Functions\FunctionController;
    use App\Http\Resources\v1\MenuCollection;
    use Illuminate\Database\Eloquent\Model;

    class Menu extends Model
    {
        protected $guarded=[];
        static public function getMainGroup(){
            $menus=Menu::where('parent_id',0)
                ->where('status',"1")
                ->orderBy('ord' ,'ASC')
                ->whereHas('main_group_childs',function ($query){
                    $query->where('status',"1")
                        ->where('price','!=',0)
                        ->where('price_discount','!=',0);
                })
                ->withCount('cargos')
                ->withCount('main_group_childs')
                ->get();
            return $menus;
        }
        static public function getSubParents($parent_id){
            $subMenus=Menu::where('parent_id',$parent_id)->where('status','1')
                ->whereHas('cargos',function ($query){
                    $query->where('status',"1")
                        ->where('price','!=',0)
                        ->where('price_discount','!=',0);
                })
                ->withCount('cargos')
                ->orderBy('ord' ,'asc')
                ->get();
            return MenuCollection::collection($subMenus);
        }
        static public function getMainGroupAdmin(){
            $menus=Menu::where('parent_id',0)
                ->orderBy('ord' ,'ASC')
                ->withCount('cargos')
                ->withCount('main_group_childs')
                ->get();
            return $menus;
        }
        static public function getSubParentsAdmin($parent_id){
            $subMenus=Menu::where('parent_id',$parent_id)
                ->withCount('cargos')
                ->orderBy('ord' ,'asc')
                ->get();
            return MenuCollection::collection($subMenus);
        }
        public function cargos()
        {
            return $this->belongsToMany(Cargo::class,'cargo_menu','menu_id','cargo_id')->withPivot('order','pivot_parent_id');
        }
        public function main_group_childs()
        {
            return $this->belongsToMany(Cargo::class,'cargo_menu','pivot_parent_id','cargo_id');
        }
    }
