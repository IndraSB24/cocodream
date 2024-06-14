<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

// Index 
$routes->get('/', 'Auth::index');

// Language
$routes->get('/lang/{locale}', 'Language::index');

// auth
$routes->get('auth-show-register', 'Auth::show_register');
$routes->post('auth-login', 'Auth::login');
$routes->post('auth-register', 'Auth::register');
$routes->get('auth-logout', 'Auth::logout');

// dashboard
$routes->get('dashboard-show', 'Dashboard::index');

// Pasien
$routes->get('pasien-get-list', 'Pasien::index');

// user
$routes->get('user-get-list', 'User::index');

// karyawan
$routes->get('karyawan-get-list', 'Karyawan::index');

// entitas usaha
$routes->get('entitas-usaha-get-list', 'Entitas_usaha::index');

// satuan
$routes->get('satuan-get-list', 'Satuan::index');

// item
$routes->get('item-get-list', 'Item::index');
$routes->get('item-show-detail/(:segment)', 'Item_detail::index/$1');

// vendor
$routes->get('vendor-get-list', 'Vendors::index');

// brand
$routes->get('brand-get-list', 'Brand::index');

// registrasi
$routes->get('registrasi-get-list', 'Registrasi::index');
$routes->get('registrasi-show-detail/(:segment)', 'Registrasi::show_registrasi_detail/$1');

// kasir
$routes->get('transaksi-show-cashier', 'Transaksi::index');
$routes->get('transaksi-get-list', 'Transaksi::show_list_transaksi');
$routes->get('transaksi-show-detail/(:segment)', 'Transaksi::show_detail_transaksi/$1');

// kategori
$routes->get('jenis-item-get-list', 'Kategori::show_jenis_item');
$routes->get('kategori-item-get-list', 'Kategori::show_kategori_item');

// hrm
$routes->get('hrm-show-absensi', 'Absensi::index');
$routes->get('hrm-show-scheduling', 'Scheduling::index');
$routes->get('hrm-show-absensi-list/(:segment)', 'Absensi::show_absensi_list/$1');

// Laporan Penjualan
$routes->get('laporanpenjualan-show', 'Laporan::index');

// Emr
$routes->get('emr-show-list', 'Emr::index');

// Inventory
$routes->get('data-stock-get-list', 'Item_stock_management::index');
$routes->get('data-transaksi-stock-get-list', 'Item_transaksi_stock::index');
$routes->get('restock-get-list', 'Item_restock::index');

// Cash Drawer
$routes->get('cashdrawer-get-list', 'Cash_drawer::index');
$routes->get('cashdrawer-get-detail/(:segment)/(:segment)', 'Cash_drawer::show_detail/$1/$2');

// payment method
$routes->get('paymentMethod-get-list', 'Payment_method::index');

// channel distribution
$routes->get('distributionChanel-get-list', 'Distribution_channel::index');

// print helper
$routes->get('get-logo-escpos', 'PrintHelper::getLogoEscpos');




// // Vertical Layout Pages Routes
$routes->get('layouts-light-sidebar', 'Home::show_layout_light_sidebar');
$routes->get('layouts-compact-sidebar', 'Home::show_layout_compact_sidebar');
$routes->get('layouts-icon-sidebar', 'Home::show_layout_icon_sidebar');
$routes->get('layouts-boxed', 'Home::show_layout_boxed');
$routes->get('layouts-preloader', 'Home::show_layout_preloader');
$routes->get('layouts-colored-sidebar', 'Home::show_layout_colored');

// Horizontal Layout Pages Routes
$routes->get('layouts-horizontal', 'Home::show_layouts_horizontal');
$routes->get('layouts-hori-topbar-light', 'Home::show_layouts_hori_topbar_light');
$routes->get('layouts-hori-boxed-width', 'Home::show_layouts_hori_boxed_width');
$routes->get('layouts-hori-preloader', 'Home::show_layouts_hori_preloader');
$routes->get('layouts-hori-colored-header', 'Home::show_layouts_hori_colored_header');

// Vertical and Horizontal Layout RTL and DARK Layout
$routes->get('vertical-rtl', 'Home::show_vertical_rtl');
$routes->get('vertical-dark', 'Home::show_vertical_dark');
$routes->get('horizontal-rtl', 'Home::show_horizontal_rtl');
$routes->get('horizontal-dark', 'Home::show_horizontal_dark');

// // Calender
$routes->get('calendar', 'Home::show_calendar');

// // Chat
$routes->get('apps-chat', 'Home::show_apps_chat');

// // Ecommerce
$routes->get('ecommerce-products', 'Home::show_ecommerce_products');
$routes->get('ecommerce-product-detail', 'Home::show_ecommerce_product_detail');
$routes->get('ecommerce-orders', 'Home::show_ecommerce_orders');
$routes->get('ecommerce-customers', 'Home::show_ecommerce_customers');
$routes->get('ecommerce-cart', 'Home::show_ecommerce_cart');
$routes->get('ecommerce-checkout', 'Home::show_ecommerce_checkout');
$routes->get('ecommerce-shops', 'Home::show_ecommerce_shops');
$routes->get('ecommerce-add-product', 'Home::show_ecommerce_add_product');

// // Email
$routes->get('email-inbox', 'Home::show_email_inbox');
$routes->get('email-read', 'Home::show_email_read');

//kanban-board
$routes->get('apps-kanban-board', 'Home::show_apps_kanban_board');

//Authentication
$routes->get('auth-login', 'Home::show_pages_login');
$routes->get('auth-register', 'Home::show_pages_register');
$routes->get('auth-recoverpw', 'Home::show_pages_recoverpw');
$routes->get('auth-lock-screen', 'Home::show_pages_lock_screen');

// // Utility
$routes->get('pages-starter', 'Home::show_pages_starter');
$routes->get('pages-maintenance', 'Home::show_pages_maintenance');
$routes->get('pages-comingsoon', 'Home::show_pages_comingsoon');
$routes->get('pages-timeline', 'Home::show_pages_timeline');
$routes->get('pages-faqs', 'Home::show_pages_faqs');
$routes->get('pages-pricing', 'Home::show_pages_pricing');
$routes->get('pages-404', 'Home::show_pages_404');
$routes->get('pages-500', 'Home::show_pages_500');

// // User Interface
$routes->get('ui-alerts', 'Home::show_ui_alerts');
$routes->get('ui-buttons', 'Home::show_ui_buttons');
$routes->get('ui-cards', 'Home::show_ui_cards');
$routes->get('ui-carousel', 'Home::show_ui_carousel');
$routes->get('ui-dropdowns', 'Home::show_ui_dropdowns');
$routes->get('ui-grid', 'Home::show_ui_grid');
$routes->get('ui-images', 'Home::show_ui_images');
$routes->get('ui-lightbox', 'Home::show_ui_lightbox');
$routes->get('ui-modals', 'Home::show_ui_modals');
$routes->get('ui-rangeslider', 'Home::show_ui_rangeslider');
$routes->get('ui-roundslider', 'Home::show_ui_roundslider');
$routes->get('ui-session-timeout', 'Home::show_ui_sessiontimeout');
$routes->get('ui-progressbars', 'Home::show_ui_progressbars');
$routes->get('ui-sweet-alert', 'Home::show_ui_sweet_alert');
$routes->get('ui-tabs-accordions', 'Home::show_ui_tabs_accordions');
$routes->get('ui-typography', 'Home::show_ui_typography');
$routes->get('ui-video', 'Home::show_ui_video');
$routes->get('ui-general', 'Home::show_ui_general');
$routes->get('ui-rating', 'Home::show_ui_rating');
$routes->get('ui-notifications', 'Home::show_ui_notifications');

// // Forms
$routes->get('form-elements', 'Home::show_form_elements');
$routes->get('form-validation', 'Home::show_form_validation');
$routes->get('form-advanced', 'Home::show_form_advanced');
$routes->get('form-editors', 'Home::show_form_editors');
$routes->get('form-uploads', 'Home::show_form_uploads');
$routes->get('form-xeditable', 'Home::show_form_xeditable');
$routes->get('form-wizard', 'Home::show_form_wizard');
$routes->get('form-mask', 'Home::show_form_mask');

// // Tables
$routes->get('tables-basic', 'Home::show_tables_basic');
$routes->get('tables-datatable', 'Home::show_tables_datatable');
$routes->get('tables-responsive', 'Home::show_tables_responsive');
$routes->get('tables-editable', 'Home::show_tables_editable');

// // // Charts
$routes->get('charts-apex', 'Home::show_charts_apex');
$routes->get('charts-chartjs', 'Home::show_charts_chartjs');
$routes->get('charts-flot', 'Home::show_charts_flot');
$routes->get('charts-knob', 'Home::show_charts_other');
$routes->get('charts-sparkline', 'Home::show_charts_sparkline');



// // // Icons
$routes->get('icons-remix', 'Home::show_icons_remix');
$routes->get('icons-materialdesign', 'Home::show_icons_material');
$routes->get('icons-dripicons', 'Home::show_icons_dripicons');
$routes->get('icons-fontawesome', 'Home::show_icons_fontawesome');

// // // Maps
$routes->get('maps-google', 'Home::show_maps_google');
$routes->get('maps-vector', 'Home::show_maps_vector');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
