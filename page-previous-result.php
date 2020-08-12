<?php get_header('header.php')?>
<section class="exam_results">
    <h1>Exam Result</h1>
    <div class="table_container">
        <table role="table">
            <thead role="rowgroup">
                <tr role="row">
                    <th>Exam Name</th>
                    <th>Full Mark</th>
                    <th>Pass Percentage</th>
                    <th>Attendance</th>
                </tr>
            </thead>
            <tbody role="rowgroup">
                <tr role="row">
                    <td class="folder_icon">
                        <a href="<?php echo site_url('/result-folder') ?>">
                            <i class="fas fa-folder"></i>
                        </a>
                        <span>Exam name</span>
                    </td>
                    <td>50</td>
                    <td>33</td>
                    <td>25</td>
                </tr>
            </tbody>
        </table>
    </div>
</section>
<?php get_footer('footer.php')?>