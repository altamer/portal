<?php

namespace App\Http\Controllers;

use App\Kindlustus;
use App\Machines;
use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class KindlustusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function debug_to_console( $data ) {
        $output = $data;
        if ( is_array( $output ) )
            $output = implode( ',', $output);
           
        echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
    }

    public function index()
    {
        $this->debug_to_console("Insur55");

        // $this->debug_to_console($insurance);
        /* 
        Kindlustused::insert($insurance);

        // return view('home');   
       // return response()->json(['name' => 'Abigail', 'state' => 'CA']);
       */
    }

    public function sendMail($message)
    {

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$mail = new PHPMailer();

// set mailer to use SMTP
$mail->IsSMTP();

// As this email.php script lives on the same server as our email server
// we are setting the HOST to localhost
$mail->Host = User::SmtpData()->pluck('smtp');  // specify main and backup server

$mail->SMTPAuth = true;     // turn on SMTP authentication

// When sending email using PHPMailer, you need to send from a valid email address
// In this case, we setup a test email account with the following credentials:
// email: send_from_PHPMailer@bradm.inmotiontesting.com
// pass: password
$mail->Username = User::SmtpData()->pluck('smtpuser');  // SMTP username
$mail->Password = User::SmtpData()->pluck('smtppass'); // SMTP password

$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption 'tls', `ssl` also accepted
$mail->Port = 465;                                    // TCP port to connect to

// $email is the user's email address the specified
// on our contact us page. We set this variable at
// the top of this page with:
// $email = $_REQUEST['email'] ;
$mail->From = 'baltiteh@baltiteh.ee';

// below we want to set the email address we will be sending our email to.
$mail->AddAddress("baltiteh@baltiteh.ee", "Balti Tehnika");

// set word wrap to 50 characters
$mail->WordWrap = 50;
// set email format to HTML
$mail->IsHTML(true);

$mail->Subject = "new reminder";

// $message is the user's message they typed in
// on our contact us page. We set this variable at
// the top of this page with:
// $message = $_REQUEST['message'] ;

// $mailmessage = $message;
// $mailmessage = json_decode($message);

// $message = json_decode($message);
// $this->debug_to_console($message->type);
// $this->debug_to_console($message['type']);
// $message = json_decode($message);
// $this->debug_to_console($message['type']);

$mailmessage = "";
$machinedata = array();


foreach($message as $item) {


// $machinedata = Machines::where('id', '=', 12)->get(); 
$machinedata = Machines::where('id', '=', $item['machineid'])->get(); 

// $mailrow = $item[$m]['machine'].' '.$item[$m]['year'].' '.$item[$m]['vin'].' Type: '.$item[$m]['type'].' Due Date: '.$item[$m]['duedate'];
// $mailrow = $item[0]['machine'].' '.$item[0]['year'].' '.$item[0]['vin'].' Type: '.$item[0]['type'].' Due Date: '.$item[0]['duedate'];

$mailrow = $machinedata[0]['machine'].' Year: '.$machinedata[0]['year'].' Vin: '.$machinedata[0]['vin'].' Type: '.$item['type'].' Due Date: '.$item['duedate'];
// $mailrow = $machinedata[0]['machine'];
// $mailrow = ' Type: '.$item['type'].' Due Date: '.$item['duedate'];
$mailmessage .= $mailrow;
$mailmessage .= "<br>";
}
// $mailmessage = $message['machine'].' '.$message['year'].' '.$message['vin'].' Type: '.$message['type'].' Due Date: '.$message['duedate'];
// $mailmessage = $message->type;

// $mailmessage = $mailmessage->type;
// $mailmessage = $mailmessage[0]['type'];

$mail->Body    = $mailmessage;
$mail->AltBody = $mailmessage;

if(!$mail->Send())
{
   echo "Message could not be sent. 
";
   echo "Mailer Error: " . $mail->ErrorInfo;
   exit;
}

echo "Message has been sent";

    }    

    public function checkdue()
    {
        $duearray = Kindlustus::DueDate();

        $this->sendMail($duearray);
        return array($duearray);

    }

    public function getdue()
    {
        $duearray = Kindlustus::DueDate();
        
        return array($duearray);

    }

    public function updateinsurance(Request $request)
    {
        $id = 0;
        $option = "";
        $date = "";
        $notes = "";
        if($request->get('id'))
       {
          $id = $request->get('id');          
        } 

        if($request->get('option'))
        {
           $option = $request->get('option');          
         }  
         if($request->get('notes'))
        {
           $notes = $request->get('notes');
           
         }  
         if($request->get('duedate'))
        {
           $date = $request->get('duedate');
           
         }
    
        Kindlustus::where('id', $id)->update(array('type' => $option, 'duedate' => $date, 'notes' => $notes));
        

        return response()->json(['success'=>'Insurance data updated.']);
    }

    public function setinsurancestatus(Request $request)
    {
        $id = 0;
        $active = 1;
        if($request->get('id'))
       {
          $id = $request->get('id');          
        } 

        if($request->get('active'))
       {
         $active = $request->get('active'); 
          
          
          if($active == 1){
            $active = 0;
           }else{
            $active = 1;           
           }
          

        } 
    
        Kindlustus::where('id', $id)->update(array('active' => $active));

        return response()->json(['success'=>'Done.']);
    }

    public function addinsurance(Request $request)
    {
       // $this->debug_to_console("Insur99");
        $notes = "";
        $option = "";
        $machineid = 0;
        $date = ""; 
        
        if($request->get('machineid'))
       {
          $machineid = $request->get('machineid');          
        } 
        if($request->get('option'))
       {
          $option = $request->get('option');          
        } 
       
        if($request->get('notes'))
       {
          $notes = $request->get('notes');
        }  
        
        if($request->get('date'))
       {
          $date = $request->get('date');
          
        }
        
        
        
        $insurance = array();
        $insurance[] = array("active" => '1', "type" => $option, "machineid" => $machineid, "notes" => $notes, "duedate" => $date);
        Kindlustus::insert($insurance);
        
        
        return response()->json(['success'=>'Insurance saved.']);
        
        
        // $this->debug_to_console($insurance);
        /* 
        Kindlustused::insert($insurance);

        // return view('home');   
       // return response()->json(['name' => 'Abigail', 'state' => 'CA']);
       */
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Kindlustus  $kindlustus
     * @return \Illuminate\Http\Response
     */
    public function show(Kindlustus $kindlustus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Kindlustus  $kindlustus
     * @return \Illuminate\Http\Response
     */
    public function edit(Kindlustus $kindlustus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Kindlustus  $kindlustus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kindlustus $kindlustus)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Kindlustus  $kindlustus
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kindlustus $kindlustus)
    {
        //
    }
}
