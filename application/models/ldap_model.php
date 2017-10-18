<?php

class Ldap_model extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    function ldap_bind2($username, $password) {
        $server = 'ldap://indonet.co.id';

        $dn="uid=zimbra,cn=admins,cn=zimbra,ou=people,dc=indonet,dc=co,dc=id" ;
        $password = 'uSb5tRfD';
//   $username=’nama_domain\\’.$username;
        $ldapconn = ldap_connect($server, '389') or die("Could not connect to {$server}");
        if ($ldapconn) {
            $connect = @ldap_bind($ldapconn, $dn, $password);
            if (!$connect) {
                echo 'user = '.$username.', password= '.$password.' gagal';
                @ldap_close($ldapconn);
//                return false;
            } else {
                echo 'berhasil';
                @ldap_close($ldapconn);
//                return true;
            }
            @ldap_close($ldapconn);
        } else {
            echo 'gagal maning';
//            return false;
            @ldap_close($ldapconn);
        }
    }

//   $ds=@ldap_connect($server.'389');  // assuming the LDAP server is on this host
//
//   if ($ds) {
//    // bind with appropriate dn to give update access
//    $connect = @ldap_bind($ds, $username, $password);
//    if(!$connect)
//    {
//     @ldap_close($ds);
//     return false;
//    }
//    else
//    {
//     @ldap_close($ds);
//     return true;
//    }
//    @ldap_close($ds);
//   }
//   else
//   {
//    return false;
//    @ldap_close($ds);
//   }
}

?>