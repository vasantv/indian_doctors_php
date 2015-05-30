<?
// This is a template for a PHP scraper on morph.io (https://morph.io)
// including some code snippets below that you should find helpful

require 'scraperwiki.php';
require 'scraperwiki/simple_html_dom.php';
//

$MAX_ID = 3; //set based on required maximum numbers

/** looping over list of ids of doctors **/
for($id = 1; $i <= $MAX_ID; $id++)
{
  // // Read in a MCI doctor page
    $html = scraperwiki::scrape("http://www.mciindia.org/ViewDetails.aspx?ID=".$id);

  // Find something on the page using css selectors
   $dom = new simple_html_dom();
   $dom->load($html);
   
   // walk through the dom and extract doctor information
   $info['doc_name'] = $dom->find('span[id=Name]')->plaintext;
   $info['doc_fname'] = $dom->find('span[id="FatherName"]')->plaintext;
   $info['doc_dob'] = $dom->find('span[id="DOB"]')->plaintext;
   $info['doc_infoyear'] = $dom->find('span[id="lbl_Info"]')->plaintext;
   $info['doc_regnum'] = $dom->find('span[id="Regis_no"]')->plaintext;
   $info['doc_datereg'] = $dom->find('span[id="Date_Reg"]')->plaintext;
   $info['doc_council'] = $dom->find('span[id="Lbl_Council"]')->plaintext;
   $info['doc_qual'] = $dom->find('span[id="Qual"]')->plaintext;
   $info['doc_qualyear'] = $dom->find('span[id="QualYear"]')->plaintext;
   $info['doc_univ'] = $dom->find('span[id="Univ"]')->plaintext;
   $info['doc_address'] = $dom->find('span[id="Address"]')->plaintext;

// print_r($dom->find("table.list"));
//
// // Write out to the sqlite database using scraperwiki library
 scraperwiki::save_sqlite(array('mci_snum','registration_number'), 
    array('mci_snum' => $id, 
          'name' => (trim($info['doc_name'])), 
          'fathers_name' => (trim($info['doc_fname'])),
          'date_of_birth' => (trim($info['doc_dob'])),
          'information_year' => (trim($info['doc_infoyear'])),
          'registration_number' => (trim($info['doc_regnum'])),
          'date_of_reg' => (trim($info['doc_datereg'])),
          'council' => (trim($info['doc_council'])),
          'qualifications' => (trim($info['doc_qual'])),
          'qualification_year' => (trim($info['doc_qualyear'])),
          'permanent_address' => (trim($info['doc_address']))
    ), "indian_doctors");
    
  //clean out the dom
  $dom->__destruct();
}
// // An arbitrary query against the database
// scraperwiki::select("* from data where 'name'='peter'")

// You don't have to do things with the ScraperWiki library.
// You can use whatever libraries you want: https://morph.io/documentation/php
// All that matters is that your final data is written to an SQLite database
// called "data.sqlite" in the current working directory which has at least a table
// called "data".
?>
