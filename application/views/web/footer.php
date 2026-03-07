<style>
/* Footer */
     footer {
       background: linear-gradient(135deg, var(--newblue2), var(--newblue));
       color: white;
       padding: 80px 10% 40px;
       position: relative;
       overflow: hidden;
     }
     
     footer::before {
       content: '';
       position: absolute;
       width: 100%;
       height: 100%;
       top: 0;
       left: 0;
       background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Ccircle cx='50' cy='50' r='1' fill='%23FFFFFF' opacity='0.05'/%3E%3C/svg%3E");
       pointer-events: none;
     }
     
     footer h2 {
       color: white;
       font-weight: 700;
     }
     
     footer .links a {
       color: #fff;
       text-decoration: none;
       margin-right: 24px;
       position: relative;
       font-weight: 500;
       transition: var(--transition);
     }
     
     footer .links a::after {
       content: '';
       position: absolute;
       width: 0;
       height: 2px;
       bottom: -4px;
       left: 0;
       background-color: var(--newblue2);
       transition: var(--transition);
     }
     
     footer .links a:hover {
       color: white;
     }
     
     footer .links a:hover::after {
       width: 100%;
     }
     
     footer .socials a {
       color: white;
       margin-right: 18px;
       font-size: 1.3rem;
       transition: var(--transition);
       display: inline-block;
     }
     
     footer .socials a:hover {
       color: var(--newblue2);
       transform: translateY(-3px);
     }
     
     footer .bottom {
       margin-top: 40px;
       font-size: 0.85rem;
       display: flex;
       flex-wrap: wrap;
       justify-content: center;
       gap: 24px;
     }
     
     footer .bottom a {
       color: #ccc;
       text-decoration: none;
       transition: var(--transition);
     }
     
     footer .bottom a:hover {
       color: var(--newblue2);
     }

      footer .links a {
         display: inline-block;
         margin-bottom: 12px;
       }

       .btn-orange {
       background: linear-gradient(135deg, var(--newblue2), var(--newblue));
       border: none;
       color: white;
       box-shadow: 0 5px 15px rgba(253, 126, 20, 0.3);
     }
     
     .btn-orange:hover {
       background: linear-gradient(135deg, var(--newblue2), var(--newblue));
       transform: translateY(-3px);
       box-shadow: 0 8px 20px rgba(253, 126, 20, 0.4);
       color: white;
     }
       
</style>
<?php
// application/views/footer.php
// Load the model directly in the view (not recommended for large apps but works)
$ci =& get_instance();
$ci->load->model('web/footer_model');

// Get footer data
$footer_data = $ci->footer_model->get_all_footer_data();
?>

<footer>
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
      <h2><?php echo htmlspecialchars($footer_data['contact_title']); ?></h2>
      <div>
        <a href="<?= base_url('index/contact_us') ?>" class="btn btn-orange">Contact</a>
        <!--<a href="<?= base_url('index/contact_us') ?>" class="btn btn-light">Consult</a>-->
      </div>
    </div>
    <p><?php echo htmlspecialchars($footer_data['contact_description']); ?></p>
    <hr class="my-4">
    <div class="d-flex justify-content-between flex-wrap align-items-center">
      <img src="<?= base_url('assets_system/images/' . $footer_data['logo']); ?>" height="40" alt="Logo">
      <div class="links">
        <?php 
        // Map menu items to URLs based on their content
        $menu_urls = [
            'Home' => '',
            'About Us' => 'about_us',
            'Products' => 'ps_prod',
            'Services' => 'ps_serv_simulation',
            'IoT Solution' => 'ps_iotsolution',
            'News and Events' => 'news_event',
            'Library' => 'library',
            'Contact Us' => 'contact_us'
        ];
        
        if(!empty($footer_data['menu'])): 
            foreach($footer_data['menu'] as $menu_item): 
                $menu_text = $menu_item->content;
                $url = isset($menu_urls[$menu_text]) ? $menu_urls[$menu_text] : strtolower(str_replace(' ', '_', $menu_text));
        ?>
        <a href="<?= base_url('index/' . $url) ?>">
            <?php echo htmlspecialchars($menu_text); ?>
        </a>
        <?php endforeach; endif; ?>
      </div>
      <div class="socials">
        <?php if(!empty($footer_data['social'])): 
            foreach($footer_data['social'] as $social_item): 
                $social_type = str_replace('social_', '', $social_item->title);
                $icon_class = '';
                
                // Determine icon class based on social type
                switch($social_type) {
                    case 'facebook':
                        $icon_class = 'fab fa-facebook-f';
                        break;
                    case 'linkedin':
                        $icon_class = 'fab fa-linkedin-in';
                        break;
                    case 'youtube':
                        $icon_class = 'fab fa-youtube';
                        break;
                    default:
                        $icon_class = 'fab fa-' . $social_type;
                }
        ?>
        <a href="<?php echo htmlspecialchars($social_item->content); ?>" target="_blank" rel="noopener noreferrer">
            <i class="<?php echo $icon_class; ?>"></i>
        </a>
        <?php endforeach; endif; ?>
      </div>
    </div>
    <div class="bottom mt-4">
      <span><?php echo htmlspecialchars($footer_data['copyright']); ?></span>
      <?php if(!empty($footer_data['policies'])): 
            foreach($footer_data['policies'] as $policy): 
                $policy_text = $policy->content;
                $policy_url = strtolower(str_replace(' ', '_', $policy_text));
      ?>
      <a href="<?= base_url('index/' . $policy_url) ?>">
          <?php echo htmlspecialchars($policy_text); ?>
      </a>
      <?php endforeach; endif; ?>
    </div>
</footer>