<?php

    namespace App\Http\Resources\v1;

    use App\Market;
    use Illuminate\Http\Resources\Json\JsonResource;

    class MenuCollection extends JsonResource
    {
        /**
         * Transform the resource into an array.
         *
         * @param  \Illuminate\Http\Request
         * @return array
         */
        public function toArray($request)
        {
                    $market=Market::find(1);
                    $folder=$market->folder_name;
                    if ($request->has('source')){
                        $path='/images/parents/'.$folder.'/'.'web'.'/';
                        $formatFile=json_decode($this->formatFile)[0];

                    }else{
                        $path='/images/parents/'.$folder.'/';
                        $formatFile=json_decode($this->formatFile)[1];
                    }
                    return [
                        'id'=>$this->id,
                        'parent_id' => $this->parent_id,
                        'image'=>file_exists(  public_path().$path.$this->id.'.'.$formatFile)?
                            env('APP_URL').$path.$this->id.'.'.$formatFile:'',
                        'name'=>$this->name,
                        'cargos_count'=>$this->cargos_count,
                        'subMenus'=>$this->subMenus
            ];
        }
    }
