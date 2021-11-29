<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use  App\Events;
use  App\Http\Requests\EventRequest;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class EventsController extends Controller
{
    public  function CreateEvent(EventRequest $request)
    {
        $event = Events::create($request->all());  
        $this->storeImage($event);
        return $event;
    }
    public  function  storeImage($event)

    {
          if(request()->has('imageevent'))
          {
              $event->update([
                    'imageevent' => request()->imageevent->store('uploads','public'),   
              ]);
              $image =  Image::make(public_path('storage/' . $event->imageevent))->fit(300,300,null, 'top-left');
              $image->save();
          }
    }
    public  function  DeleteEvent($id)
    {   
        $event = Events::findOrFail($id);
        $imagePath = '/public/'. $event->imageevent; 

        if(Storage::exists($imagePath))
           {
                Storage::delete($imagePath);
                $event->delete();
                
                return 1;
            } 
        else
            {
                return 0;
            }
    }
    public  function  FindEvent($id)
    {   
        return $event = Events::findOrFail($id);
      
    }
    public  function  AllEvent()
    {   
        return $event = Events::all();
      
    }
      
}
