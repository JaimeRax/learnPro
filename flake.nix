{
    description = "A multi-architecture flake for development environments";

    inputs = {
        nixpkgs.url = "github:nixos/nixpkgs?ref=nixos-unstable";
    };

    outputs = { self, nixpkgs }:
        let
            # Helper function to create a shell for different architectures
            makeDevShell = system:
                let
                    pkgs = import nixpkgs {
                        inherit system;
                        config.allowUnfree = true;
                    };
                in pkgs.mkShell {
                        buildInputs = [
                            pkgs.git
                            # base stuff
                            pkgs.php
                            pkgs.nodejs
                            pkgs.yarn
                            pkgs.curl
                            pkgs.zip
                            pkgs.unzip
                            # composer
                            pkgs.php82Packages.composer
                            # extensions
                            pkgs.php82Extensions.intl
                            pkgs.php82Extensions.bcmath
                            pkgs.php82Extensions.curl
                            pkgs.php82Extensions.mysqli
                            pkgs.php82Extensions.xml
                            pkgs.php82Extensions.zip
                            pkgs.php82Extensions.soap
                            pkgs.php82Extensions.mbstring
                            pkgs.php82Extensions.gd
                            pkgs.php82Extensions.ftp
                            pkgs.php82Extensions.imap
                            # optional
                            pkgs.php82Extensions.xdebug
                            # packages
                            pkgs.php82Packages.php-cs-fixer
                            pkgs.intelephense
                            pkgs.blade-formatter
                            pkgs.nodePackages.prettier
                            # extras
                            pkgs.pdftk
                        ];

                        shellHook = ''
                      php -v
                      composer --version
                      '';
                    };
        in {
            devShells."aarch64-darwin".default = makeDevShell "aarch64-darwin";
            devShells."x86_64-linux".default = makeDevShell "x86_64-linux";
            devShells."x86_64-darwin".default = makeDevShell "x86_64-darwin";
        };
}
