<?php
namespace Assets;

/**
 * Verifies and Hashes Passwords or any string given
 * @package  Credentials
 * @author  Neo Morina <neomorina@gmail.com>
 */
class Credentials
{
    
    const DEFAULT_HASH = PASSWORD_BCRYPT;

    function __construct()
    {

    }

    /**
     * Generates the Hash of a string
     * @param string $pass     string/password to be hashed
     * @param string $HashType the type of hash used to hash the password
     */
    public function Hash($pass, $HashType = PASSWORD_DEFAULT){
        return password_hash($pass, $HashType);
    }

    /**
     * Verifies if the password is equals to the Hash from DB
     * @param string $pass the string/password given to be checked if the are equaly
     * @param string $hash the hash from the database
     */
    public function VerifyHash($pass, $hash){
        $filteredHash = end(explode("||", $hash)); // Filter the hash from database and give the real hash
        return password_verify($pass, $filteredHash); 
    }

    /**
     * Encrypt and decrypt
     *
     * @param string $string string to be encrypted/decrypted
     * @param string $action what to do with this? e for encrypt, d for decrypt
     */
    public function CCrypt( $string, $action = 'e' ) {
        // you may change these values to your own
        $secret_key = 'ooisihdodiiugdadzgfwefufaifzufwazgfaavvvcyvgcazvvfassahgvaksggvf';
        $secret_iv = 'lgaigfzgakzegfgazwfefif612368tewf766rtfaewfkhsdofuwjhnxcmbbcmnbcy';
     
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $key = hash( 'sha256', $secret_key );
        $iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );
     
        if( $action == 'e' ) {
            $output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
        }
        else if( $action == 'd' ){
            $output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
        }
     
        return $output;
    }
}