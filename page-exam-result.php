<?php get_header('header.php')?>
<section class="exam_results">
    <h1>Exam Result</h1>
    <div class="table_container">
        <table role="table">
            <thead role="rowgroup">
                <tr role="row">
                    <th >Exam Name</th>
                    <th >Student Name</th>
                    <th >Full Mark</th>
                    <th >Student Mark</th>
                    <th >Status</th>
                </tr>
            </thead>
            <tbody role="rowgroup">
                <tr role="row">
                    <td >James</td>
                    <td >Matman</td>
                    <td >Chief Sandwich Eater</td>
                    <td >Lettuce Green</td>
                    <td class="pass_txt"><span>Passed</span></td>
                </tr>
                <tr role="row">
                    <td >James</td>
                    <td >Matman</td>
                    <td >Chief Sandwich Eater</td>
                    <td >Lettuce Green</td>
                    <td class="pass_txt"><span>Passed</span></td>
                </tr>
                <tr role="row">
                    <td >James</td>
                    <td >Matman</td>
                    <td >Chief Sandwich Eater</td>
                    <td >Lettuce Green</td>
                    <td class="pass_txt"><span>Passed</span></td>
                </tr>
            </tbody>
        </table>
    </div>
</section>
<section class="result-sec">
<a href="<?php echo site_url('/previous-result') ?>">Previous Results</a>
</section>
<?php get_footer('footer.php')?>