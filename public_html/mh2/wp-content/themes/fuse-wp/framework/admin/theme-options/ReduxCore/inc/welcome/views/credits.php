<div class="wrap about-wrap">
    <h1><?php esc_html_e( 'Redux Framework - A Community Effort', 'fuse-wp' ); ?></h1>

    <div
        class="about-text"><?php esc_html_e( 'We recognize we are nothing without our community. We would like to thank all of those who help Redux to be what it is. Thank you for your involvement.', 'fuse-wp' ); ?></div>
    <div
        class="redux-badge"><i
            class="el el-redux"></i><span><?php printf( esc_html__( 'Version %s', 'fuse-wp' ), ReduxFramework::$_version ); ?></span>
    </div>

    <?php $this->actions(); ?>
    <?php $this->tabs(); ?>

    <p class="about-description"><?php
            echo sprintf( esc_html__( 'Redux is created by a community of developers world wide. Want to have your name listed too? %d Contribute to Redux.', 'fuse-wp' ), 'https://github.com/reduxframework/redux-framework/blob/master/CONTRIBUTING.md' );
        ?></p>

    <?php echo $this->contributors(); ?>
</div>