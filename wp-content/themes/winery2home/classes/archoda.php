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


 // https://codex.wordpress.org/Plugin_API/Action_Reference

class ARCHODA 
{

	/* 
	 * ARC Constants 
	*/
	public static string $ENV_URI_ERROR_MESSAGE = 'The environemt URI\'s provided do not match and could not be set-up. Please provide a proper uri.';

	/* 
	 * ARC Properties 
	*/
	public $Error = null;

	public ?array $Env = null;

	public string $Env_Uri = '';
	public string $Env_Uri_Development = '.local';
	public string $Env_Uri_Staging = '';
	public string $Env_Uri_Production = '';

	public bool $Env_Debug = false;
	public bool $Env_Debug_Development = true;
	public bool $Env_Debug_Staging = true;
	public bool $Env_Debug_Production = false;
	
	public string $Env_Theme_Name = 'winery2home';

	public bool $Env_Admin = false;
	public bool $Env_Admin_Preview = false;

	/* 
	 * ARC_THEME Constructor 
	*/

	function __construct()
	{	
//$this->Error = new $_Error();// var_dump($this->Error);
		
		// $this::Env_Set();
		// $this::Config_Set();
		// $this::ARC_Init_Set();
	}


	function Env_Set()
	{
		// It's aready set
		if ($this->Env_Uri != '') return;

		// Set Env base on dev uri
		if (strpos(gethostname(), $Env_Uri_Development))
		{
			$this->Env_Uri = gethostname();
		}
		// Set Env base on a stage uri
		elseif(strpos(gethostname(), $Env_Uri_Staging))
		{

		}
		// Set Env base on a production uri
		elseif(strpos(gethostname(), $Env_Uri_Production))
		{

		}
		// Set Env error since we've not detect anything proper
		else
		{
			die(self::$ENV_URI_ERROR_MESSAGE);
		}
	}

	/* 
	 * ARC Configuration 
	*/

	function Config_Set()
	{
		$this->WP_Admin = (is_admin()) ? true : false;
		$this->WP_Admin_Preview = (isset($_GET['preview'])) ? true : false; // detect query since wp's is_preview() returns false
	}

	// /* 
	//  * ARC Initialization 
	// */

	// function ARC_Init_Set()
	// {
	// 	// Run Admin specific code
	// 	if ($this->Env_Admin)
	// 	{
	// 		add_action('admin_init', [$this, 'ARC_Init_Admin']);
	// 	}

	// 	// Run Theme specific code
	// 	if (!$this->Env_Admin || $this->Env_Admin_Preview)
	// 	{
	// 		add_action('wp', [$this, 'ARC_Init_Theme']);
	// 	}
	// }

	// // ARC Admin Hook Initialization
	// function ARC_Init_Admin()
	// {
	// 	echo 'DO ADMIN STUFF';
	// }

	// // ARC Theme Hook Initialization
	// function ARC_Init_Theme()
	// {
	// 	echo 'DO NON ADMIN STUFF FOR THEME ' . $this->Env_Theme_Name;
	// }
}

?>