<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use  App\News;
use  App\Http\Requests\NewRequest;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    public  function CreateNew(NewRequest $request)
    {
        $news = News::create($request->all());  
        $this->storeImage($news);
        return $news;
    }
    public  function  storeImage($news)

    {
          if(request()->has('imagenews'))
          {
              $news->update([
                    'imagenews' => request()->imagenews->store('news','public'),   
              ]);
              $image =  Image::make(public_path('storage/' . $news->imagenews))->fit(600,355,null, 'top-left');
              $image->save();
          }
    } 
    public  function  DeleteNew($id)
    {   
        $new = News::findOrFail($id);
        $imagePath = '/public/'. $new->imagenews; 

        if(Storage::exists($imagePath))
           {
                Storage::delete($imagePath);
                $new->delete();
                
                return 1;
            } 
        else
            {
                return 0;
            }
    }
    public  function  FindNew($id)
    {   
        return $new = News::findOrFail($id);
      
    }
    public  function  AllNew()
    {   
        return $new = News::all();
      
    }
    public  function UpdateNew(Request $request , $id)
    {   $new = News::findOrFail($id);
         $request->validate([
           
            'titrenews' => 'required',
            'descriptionnews' => 'required', 
            'imagenews' => 'required',
        ]);
       
        $new->titrenews =  $request->titrenews;
        $new->descriptionnews =  $request->descriptionnews;
        if($request->hasFile('imagenews'))
        {
            $imagePath = '/public/'. $new->imagenews; 
           Storage::delete($imagePath);
            $new->imagenews =  $request->imagenews;
            $this->storeImage($new);
            $new->save();
            return  $new;
        }
        else
        {
            $new->imagenews =  $new->imagenews;
            $new->save();
            return   $new;
        }
      
 

    }
    public  function FirstNew()
    {
        $new = News::latest()->first();
        return $new;
    }
}
