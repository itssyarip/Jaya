<?php

  /**
  * ldap.config.example.php is sample configuration file for ldap authentication. 
  * Rename it in ldap.config.php and change the values depending on your environment
  * 
  *  
  * @author Luca Corbo <luca.corbo@2bopen.org>
  * 
  * Further information about LDAP settings within Feng Office can be found her:
  * http://www.fengoffice.com/web/wiki/doku.php/ldap
  * 
  */
 
 $config_ldap = array (
      'binddn'    => 'uid=zimbra,cn=admins,cn=zimbra',
      'bindpw'    => 'uSb5tRfD',
      'basedn'    => 'ou=people,dc=indonet,dc=co,dc=id',
      'host'      => 'ldap://indonet.co.id',
      'port'      => 389,    
      'uid' => 'uid', //unique id to match with the LDAP and the username
  );
  return true;
  
?>
