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
    public  function FirstEvent()
    {
        $event = Events::latest()->first();
        return $event;
    }
    public  function  storeImage($event)

    {
          if(request()->has('imageevent'))
          {
              $event->update([
                    'imageevent' => request()->imageevent->store('uploads','public'),   
              ]);
              $image =  Image::make(public_path('storage/' . $event->imageevent));
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
    public  function UpdateEvent(Request $request , $id)
    {   $event = Events::findOrFail($id);

         $request->validate([
           
            'titreevent' => 'required',
            'descriptionevent' => 'required', 
            'imageevent' => 'required',
        ]);
        $event->titreevent=  $request->titreevent;
        $event->descriptionevent =  $request->descriptionevent;
        if($request->hasFile('imageevent'))
        {
            $imagePath = '/public/'.$event->imageevent; 
            Storage::delete($imagePath);
            $event->imageevent =  $request->imageevent;
            $this->storeImage($event);
            $event->save();
            return  $event;
        }
        else
        {
            $event->imageevent =  $event->imageevent;
            $event->save();
            return  $event;
        }
 

    }
      
}
