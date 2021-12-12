<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use  App\Presentation;
use  App\Http\Requests\PresentationRequest;
use Illuminate\Support\Facades\Storage;

class PresentationController extends Controller
{
    public  function  storeFile($presentation)

    {
          if(request()->hasFile('pres') && request()->file('pres')->isValid())
          {
              $file = request()->file('pres');
              $originalName = $file->getClientOriginalName();
              $fileLoc =  request()->pres->storeAs('/public/file', $originalName);
              $mimeType = Storage::mimeType($fileLoc);
              $presentation->update([
                'pres' => $fileLoc,
            ]);
               return  $mimeType;
           }
           else 
           { 
              return  0;
           }
    } 
     public  function CreatePresentation(PresentationRequest $request)
     {
        $presentation = Presentation::create($request->all());  
        $this->storeFile($presentation);
        return $presentation;
     }
     public  function  FindPresentation($id)
     {   
         return $presentation = Presentation::findOrFail($id);
       
     }
     public  function  AllPresentation()
     {   
         return $presentation = Presentation::all();
       
     }
     public  function UpdatePresentation(Request $request , $id)
     {   $presentation = Presentation::findOrFail($id);
          $request->validate([
            
             'titre' => 'required',
             'description' => 'required', 
             'pres' => 'required',
             'video' => 'required',
         ]);
        
         $presentation->titre =  $request->titre;
         $presentation->description =  $request->description;
         $presentation->video =  $request->video;
         if($request->hasFile('pres'))
         {
             $filePath = '/'. $presentation->pres; 
             Storage::delete($filePath);
             $presentation->pres =  $request->pres;
             $this->storeFile($presentation);
             $presentation->save();
             return  $presentation;
         }
         else
         {
            $presentation->pres =  $presentation->pres;
            $presentation->save();
             return   $presentation;
         }
       }
       public  function FirstPresentation()
       {
           $presentation = Presentation::latest()->first();
           return $presentation;
       }
       public  function  DeletePresentation($id)
       {   
   
           $presentation = Presentation::findOrFail($id);
           $filePath = '/'. $presentation->pres; 
          Storage::delete($filePath);
           return $presentation->delete();
       }
       public  function  Download($id)
       {
            $presentation = Presentation::findOrFail($id);
            //$file = Storage::download($presentation->pres);
           // return response()->json($file);
               return Storage::url($presentation->pres);
         
       }
}
