#!/usr/bin/perl -w
#
# @File switch_env.pl
# @Author jmcd
# @Created May 18, 2016 2:20:02 PM
#

use strict;
use FindBin;

my $file = "$FindBin::Bin/../Config/core.php";
my $debug = $ARGV[0] || 0;

my $debug_txt = 'FALSE';
my $db_config = 'default';

if ( $debug != 0 ){
    $debug_txt = "TRUE";
    $db_config = 'pallets3';
    print "Setting to TEST Env\n";
    
    } else {
        
        print "Setting to LIVE Env\n";
        
        }

open(FILE, "<$file") || die "File not found";
my @lines = <FILE>;
close(FILE);

my @newlines;
foreach(@lines) {
   $_ =~ s/(Configure::write\('debug',)\s*(\d)(\);)/${1}$debug${3}/g;
   $_ =~ s/(Configure::write\('pallet_print_debug',)\s*(\w+)\s*(\);)/${1}$debug_txt${3}/ig;
   push(@newlines,$_);
}

open(FILE, ">$file") || die "File not found";
print FILE @newlines;
close(FILE);

$file = "$FindBin::Bin/../Model/AppModel.php";

open(FILE, "<$file") || die "File not found";
@lines = <FILE>;
close(FILE);

undef(@newlines);
foreach(@lines) {
   $_ =~ s/(public \$useDbConfig = ')(\w+)(';)/${1}$db_config${3}/ig;
   push(@newlines,$_);
}

open(FILE, ">$file") || die "File not found";
print FILE @newlines;
close(FILE);


