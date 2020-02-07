<div class="container">
    <div class="col-sm-12 col-md-offset-2 col-md-8 col-lg-8 col-lg-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Help</h3>
            </div>

            <div class="panel-body">
                <h5>Contact</h5>
                <p><strong><?= Configure::read('applicationName'); ?></strong> is designed and maintained by <?php echo $this->Html->link(
    Configure::read('contact.company'),
    Configure::read('contact.company_url'),
    ['rel' => 'noreferrer',
        'target' => '_blank',
        'title' => 'Click here to visit ' . Configure::read('contact.company'), ]
); ?></p>
                <p>Please phone
                    <em><?php echo $this->Html->link(Configure::read('contact.phone'), 'tel:' . Configure::read('contact.phone_dial')); ?></em>
                    for assistance</p>

            </div>
            <?php if ($isLoggedIn): ?>
            <table class="table table-striped table-condensed">
                <tr>
                    <th colspan="2">
                        <h5>Software Environment</h5>
                    </th>
                </tr>
                <tr>
                    <th>Bootstrap Version</th>
                    <td>
                        <div id="twbs_version"></div>
                        <?php $this->Html->scriptStart(['block' => 'from_view']);
                                echo '$(function () {' .
                                    '$.get("' . $this->Html->url('/css/bootstrap.min.css') .
                                        '", function (data) {' .
                                        'var version = data.match(/v[.\d]+[.\d]/);' .
                                        '$("#twbs_version").html(version); }); });';
                              $this->Html->scriptEnd(); ?>
                    </td>
                </tr>
                <tr>
                    <th>PHP Version</th>
                    <td> <?php echo phpversion(); ?></td>
                </tr>
                <tr>
                    <th>PHP Framework</th>
                    <td><?php
                                               echo $this->Html->link('CakePHP ' . Configure::version(), 'http://www.cakephp.org', ['target' => '_blank']);
                                           ?>
                    </td>
                </tr>
                <tr>
                    <th>Web Server</th>
                    <td> <?php echo env('SERVER_SOFTWARE'); ?>
                    </td>
                </tr>
                <tr>
                    <th>Server Name</th>
                    <td> <?php echo gethostname(); ?></td>
                </tr>
                <tr>
                    <th>
                        Operating System</th>
                    <td> <?php echo php_uname('a'); ?></td>
                </tr>

                <tr>
                    <th>IP Address</th>
                    <td><?php echo env('SERVER_ADDR'); ?></td>
                </tr>



                <tr>
                    <th>Database Server Host</th>
                    <td> <?php echo $dbConfig['host']; ?></td>
                </tr>
                <tr>
                    <th>
                        Database configuration</th>
                    <td> <?php echo $dbConfig['config']; ?></td>
                </tr>
                <tr>
                    <th>
                        Current database</th>
                    <td><?php echo $dbConfig['database']; ?></td>
                </tr>

                <tr>
                    <th>Print Debug</th>
                    <td> <?php echo (bool)Configure::read('pallet_print_debug') ? 'TRUE' : 'FALSE'; ?></td>
                </tr>

            </table>
            <?php endif; ?>
        </div>
    </div>
</div>