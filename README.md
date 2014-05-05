Flinks-Redirect-Foldr
=====================

PHP Foldr Private Flink Redirecter

The PHP file called foldrHandler.php will interpret HTTP GET requests containing the users requested flink, username to access the file and their password encrypted using AES with a private key.

It is strongly reccomended that you change this private key!

This code was originally used for connecting to a server to request resources over HTTPS.
Unfortuantly the server was running a unsigned certificate therefore this was used to bypass the issue.

You can make this request from an iOS application (using xcode):

    - (IBAction)login:(id)sender {
      //Login to foldr
    
      //initialize url that is going to be fetched.
      NSString *flink = [[NSUserDefaults standardUserDefaults] stringForKey:@"flink"];
      //Gets the username from a predefined text field in the .h file
      NSString *username = [NSString stringWithFormat:@"username=%@", usernameField.text];
    
      //Code for sending password to the API ready for interpretation by Foldr

      NSString *key = @"alongkey16bytes!along16byteskey!";
      //Gets the password from a predefined text field in the .h file
      NSString *plaintext = passwordField.text;
    
      NSString *ciphertext = [plaintext AES256EncryptWithKey: key];
      NSLog(@"Cipher: %@", ciphertext);
    
      NSString *unencodedString = ciphertext;
    
     NSString *encodedString = (NSString *)CFURLCreateStringByAddingPercentEscapes(
                                                                                  NULL,
                                                                                  (CFStringRef)unencodedString,
                                                                                  NULL,
                                                                                  (CFStringRef)@"!*'();:@&=+$,/?%#[]",
                                                                                  kCFStringEncodingUTF8 );
      NSLog(@"%@", encodedString);
    
      //Creates the link containing the encrypted password
      NSString *auth = [NSString stringWithFormat:@"auth=%@", encodedString];
      NSString *flinkURL = [NSString stringWithFormat:@"http://URLLocationOfHandler.com/foldrHandler.php?flink=%@&%@&%@", flink, username, auth];
      NSURL *login = [NSURL URLWithString:flinkURL];
    
      //Login in safari
      [[UIApplication sharedApplication] openURL:login];
    
    }

I would like to point out that this code is still used for testing purposes to request resources within a school enviroment and could change depending on Foldr Encryptions. But for a "stumble in the dark" I hope this may solve some challenges other developers may be facing with implementation within School's or Businesses :)

Finally, Foldr is the respective property of Minnow IT (2014). I would highly suggest crediting them whenever this is used.

Lewis Smallwood
