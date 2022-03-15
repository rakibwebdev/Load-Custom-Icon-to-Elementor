// elementor icon fonts loaded
    public function elementor_icon_pack(  ) {

		$this->__generate_font();
		
        add_filter( 'elementor/icons_manager/additional_tabs', [ $this, '__add_font']);
		
    }
    
    public function __add_font( $font){
        $font_new['icon-id'] = [
            'name' => 'icon-id',
            'label' => esc_html__( 'Custom Icons', 'textdomain' ),
            'url' => CSS_Path . '/icon-font.css',
            'enqueue' => [ CSS_Path . '/icon-font.css' ],
            'prefix' => 'icon-',
            'displayPrefix' => 'icon',
            'labelIcon' => 'icon icon-play',
            'ver' => '5.9.1',
            'fetchJson' => JS_Path . '/icon-font.js',
            'native' => true,
        ];
        return  array_merge($font, $font_new);
    }


    public function __generate_font(){
        global $wp_filesystem;

        require_once ( ABSPATH . '/wp-admin/includes/file.php' );
        WP_Filesystem();
        $css_file =  CSS_DIR . '/icon-font.css';
    
        if ( $wp_filesystem->exists( $css_file ) ) {
            $css_source = $wp_filesystem->get_contents( $css_file );
        } // End If Statement
        
        preg_match_all( "/\.(icon-.*?):\w*?\s*?{/", $css_source, $matches, PREG_SET_ORDER, 0 );
        $iconList = []; 
        
        foreach ( $matches as $match ) {
            $new_icons[$match[1] ] = str_replace('icon-', '', $match[1]);
            $iconList[] = str_replace('icon-', '', $match[1]);
        }

        $icons = new \stdClass();
        $icons->icons = $iconList;
        $icon_data = json_encode($icons);
        
        $file = THEME_DIR . '/assets/js/icon-font.js';
        
            global $wp_filesystem;
            require_once ( ABSPATH . '/wp-admin/includes/file.php' );
            WP_Filesystem();
            if ( $wp_filesystem->exists( $file ) ) {
                $content =  $wp_filesystem->put_contents( $file, $icon_data) ;
            } 
        
    }
