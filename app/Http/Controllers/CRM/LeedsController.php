<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use http\Message;
use Illuminate\Http\Request;
use App\Models\CRM\Leeds;
use App\Models\CRM\Group;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class LeedsController extends Controller
{
    private $leed;
    private $group;
    private $message;
    private $leeds;
    private $directory;
    private $image;
    private $imageName;
    private $imageUrl;

    public function __construct()
    {
    $this->middleware('auth');
    }
    public function index()
    {
        $users = User::orderBy('id', 'desc')->get();
        $groups = Group::orderBy('id', 'desc')->get();
        return view('CRM.leeds.leeds',['users'=>$users])->with('groups', $groups);
    }
    public function getImageUrl($request)
    {
        $this->image = $request->file('logo');
        $this->imageName = $this->image->getClientOriginalName();
        $this->directory = 'leed-images/';
        $this->image->move($this->directory, $this->imageName);
        $this->imageUrl = $this->directory.$this->imageName;
        return $this->imageUrl;
    }
    public function create(Request $request)
    {
        $this->leed = new Leeds();
        if($this->image=$request->file('logo'))
        {
            if (file_exists($this->leed->image))
            {
                unlink($this->leed->image);
            }
            $this->imageUrl = $this->getImageUrl($request);
        }
        else
        {
            $this->imageUrl = $this->leed->image;
        }
        $this->leed->clientName = $request->clientName;
        $this->leed->leedsGroupId = $request->leedsGroupId;
        $this->leed->phoneNo = $request->phoneNo;
        $this->leed->email = $request->email;
        $this->leed->address = $request->address;
        $this->leed->area = $request->area;
        $this->leed->district = $request->district;
        $this->leed->zipCode = $request->zipCode;
        $this->leed->website = $request->website;
        $this->leed->country = $request->country;
        $this->leed->clientPriority = $request->clientPriority;
        $this->leed->clientValue = $request->clientValue;
        $this->leed->source = $request->source;
        $this->leed->assignedTo = $request->assignedTo;
        $this->leed->comment = $request->comment;
        $this->leed->status = $request->status;
        $this->leed->logo = $this->imageUrl;
        $this->leed->save();
        return redirect()->back()->with('Create_Message', 'New Leed Created Successfully');
    }
    public function leedlist()
    {
        $this->leeds = Leeds::orderBy('id', 'desc')->where('issuccess','0')->get();
        return view('CRM.leeds.allLeads',['leeds'=>$this->leeds]);
    }
    public function edit($id)
    {
        $this->leeds = Leeds::find($id);
        return view('CRM.leeds.editLeeds',['leeds'=>$this->leeds]);
    }
    public function update(Request $request, $id)
    {
        $this->leed = Leeds::find($id);
        if($this->image=$request->file('logo'))
        {
            if (file_exists($this->leed->image))
            {
                unlink($this->leed->image);
            }
            $this->imageUrl = $this->getImageUrl($request);
        }
        else
        {
            $this->imageUrl = $this->leed->image;
        }
        $this->leed->clientName = $request->clientName;
        $this->leed->phoneNo = $request->phoneNo;
        $this->leed->email = $request->email;
        $this->leed->address = $request->address;
        $this->leed->area = $request->area;
        $this->leed->district = $request->district;
        $this->leed->zipCode = $request->zipCode;
        $this->leed->website = $request->website;
        $this->leed->country = $request->country;
        $this->leed->clientPriority = $request->clientPriority;
        $this->leed->clientValue = $request->clientValue;
        $this->leed->source = $request->source;
        $this->leed->assignedTo = $request->assignedTo;
        $this->leed->comment = $request->comment;
        $this->leed->status = $request->status;
        $this->leed->logo = $this->imageUrl;
        $this->leed->save();
        return redirect('/leedsList')->with('Update_Message', 'Leed updated successfully');
    }
    public function delete($id)
    {
        $this->leed = Leeds::find($id);
        if (file_exists($this->leed->image))
        {
            unlink($this->leed->image);
        }
        $this->leed->delete();
        return redirect('/leedsList')->with('Delete_Message', 'Leed deleted successfully');
    }
    public function promoteDemoteLeed($id)
    {
        $this->leed = Leeds::find($id);
        if ($this->leed->isSuccess == 0)
        {
            $this->leed->isSuccess = 1;
            $this->message = 'Updated To Success Leed';
        }
        else
        {
            $this->leed->isSuccess = 0;
            $this->message = 'Updated To Leed';
        }
        $this->leed->save();
        return redirect('/leedsList')->with('Status_Message','Leeds Status Changed  Successfully');
    }
    public function successList()
    {
        $this->leeds = Leeds::where('isSuccess', 1)->get();
        return view('CRM.leeds.allSuccessLeeds',['leeds'=>$this->leeds]);
    }







}
