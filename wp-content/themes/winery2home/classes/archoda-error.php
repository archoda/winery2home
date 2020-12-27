<?php

/**
 * Set WP Congif for customized theme, functions, plugins, etc...
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *  
 * 	
 * 1. Set the Env URI's for Stage and Production
 * 2. ...
 * @since 1.0.0
 */

class ARCHODA_ERROR
{   
    /*
    * Summary: Error array collection
    * Description: This will hold all of the errors reported in the system. 
    * @since 1.0.0
    *
    * @var type $Array.
    */
    private array $Error = [];

    /*
    * Summary: Error Last array collection
    * Description: This will hold all of the parsed error data reported and pushed into the error history. 
    * @since 1.0.0
    *
    * @var type $Array.
    */
    private array $Error_Last = [];

    /*
    * Summary: Error History array collection
    * Description: This will hold all of the systems reported errors during the session.
    * @since 1.0.0
    *
    * @var type $Array.
    */
    public array $Error_History = [];

    /*
    * Summary: Error Date/Time Stamp
    * Description: This will hold the custom date/time stamp data generated at the time of the errors' recording.
    * @since 1.0.0
    *
    * @var type $String.
    */
    private string $Error_Date_Time = '';

    /*
    * Summary: Error Date/Time Stamp
    * Description: This will hold the type data of the error being reported.
    * @since 1.0.0
    *
    * @var type $Integer.
    */
    private int $Error_Type = 0;

    /*
    * Summary: Error Date/Time Stamp
    * Description: This will hold the string message of the error being reported.
    * @since 1.0.0
    *
    * @var type $String.
    */
    private string $Error_Message = '';

    /*
    * Summary: Error Date/Time Stamp
    * Description: This will hold the string path of the file where the error found and reported.
    * @since 1.0.0
    *
    * @var type $String.
    */
    private string $Error_File_Name = '';

    /*
    * Summary: Error File Name
    * Description: This will hold the integer of the line number in the file where the error reported.
    * @since 1.0.0
    *
    * @var type $Integer.
    */
    private int $Error_Line_Number = 0;

    /*
    * Summary: Error Backtrace
    * Description: This will hold the integer of the line number in the file where the error reported.
    * @since 1.0.0
    *
    * @var type $String.
    */
    private string $Error_Stacktrace = '';

    /*
    * Summary: Error Inner Stacktrace
    * Description: This will hold the stringified output from the `debug_backtrace` function when the error reported.
    * @since 1.0.0
    *
    * @var type $String.
    */
    private string $Error_Inner_Stacktrace = '';


    /*
    * Summary: ARCHODA_ERROR Class constructor
    * Description: This class will handle and maintain the systems error's reported during each session.
    * @since 1.0.0
    *
    * @Class Constructor.
    */
    public function __construct()
    {   
        // Do nothing....
    }

    /*
    * Summary: ARCHODA_ERROR handle initialializer
    * Description: This class truigger the handling each error when called as the callback during captured errors
    * @since 1.0.0
    *
    * @var type $Function.
    */
    public function Error_Handle()
    {
        // Run Error Report
        $this->Error_Report();

        // Return Error History
        return $this->Error_History;
    }

    /*
    * Summary: ARCHODA_ERROR parsing and reporting
    * Description: This method will get the last error reported, parse it, and record it to the error history collection
    * @since 1.0.0
    *
    * @var type $Function.
    */
    private function Error_Report()
    {
        // Retreive last error
        $this->Error_Last = error_get_last();

        // Loop over the error...if not empty
        if (count($this->Error_Last) != 0)
        {
            try {
                // Parse Error data
                $this->Error_Date_Time = date('D, F j Y; Y-m-d; g:i:s:u; A; eP');
                $this->Error_Message = str_replace('Uncaught Exception: ', '', explode('in /', $this->Error_Last['message'])[0]);
                $this->Error_Type = $this->Error_Last['type'];
                $this->Error_File_Name = $this->Error_Last['file'];
                $this->Error_Line_Number = $this->Error_Last['line'];
                $this->Error_Stacktrace = explode(': ', $this->Error_Last['message'])[1];
                $this->Error_Inner_Stacktrace = json_encode(debug_backtrace());
            }
            catch (Exception $e)
            {
                // Parse Error data w/o any custom parsing
                $this->Error_Date_Time = date('D, F j Y; Y-m-d; g:i:s:u; A; eP');
                $this->Error_Message = 'Unknown Exception: See Stacktrace';
                $this->Error_Type = $this->Error_Last['type'];
                $this->Error_File_Name = $this->Error_Last['file'];
                $this->Error_Line_Number = $this->Error_Last['line'];
                $this->Error_Stacktrace = $this->Error_Last['message'];
                $this->Error_Inner_Stacktrace = json_encode(debug_backtrace());
            }

            // Append Error
            $this->Error['Date/Time'] = $this->Error_Date_Time;
            $this->Error['Type'] = $this->Error_Type;
            $this->Error['Message'] = $this->Error_Message;
            $this->Error['File'] = $this->Error_File_Name;
            $this->Error['Line'] = $this->Error_Line_Number;
            $this->Error['Stacktrace'] = $this->Error_Stacktrace;
            $this->Error['Inner Exception'] = $this->Error_Inner_Stacktrace;

            // Append Error to Error History
            array_push($this->Error_History, $this->Error);

            // Clear the last error
            error_clear_last();
        }
    }

}