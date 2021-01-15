# custom_widget
wordpress custom widget 是对wp自带的widget class的重写，所有参数传递

基本结构为首先创建结构函数，然后创建output输出html,output里面又开始写入wp的模板函数来输出wp的动态内容。

然后创建后台input输入框，通过name值来进行数据写入。

然后创建update函数，来写入并保存到数据库。

把这个class php文件放在inc文件夹下面的widgets文件夹里，

require get_template_directory() . '/framework/widgets/class-abt-custom-nav-menu-widget.php';

然后在functions.php里面引入并注册widget:

//widgets api https://codex.wordpress.org/Widgets_API

function abt_register_custom_widgets() {
	register_widget( 'Custom_WP_Nav_Menu_Widget' );
}

add_action('widgets_init','abt_register_custom_widgets');

wordpress主题开发教学QQ群：706173813
