<? include('../header.php'); 


if ($assignedLho) {

    echo 'No permission to access this page !' ; 

}else{



?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
<style>
    /* Image preview with a default size of 300x300 */
    .image-preview {
        max-width: 300px;
        max-height: 300px;
    }

    #modalBody a {
        margin: 10px;
        display: inline-block;
    }
</style>


                    <?
                    $statement = "select * from sealVerification where status=1 and isVerify in (0,1,2) ";
                    $sqlappCount = "select count(1) as totalCount from sealVerification where status=1 and isVerify in (0,1,2) ";

                    if (isset($_REQUEST['atmid']) && $_REQUEST['atmid'] != '') {
                        $atmid = $_REQUEST['atmid'];
                        $statement .= "and atmid like '%" . trim($atmid) . "%'";
                        $sqlappCount .= "and atmid like '%" . trim($atmid) . "%'";
                    }


                    $statement .= "order by id desc";

                    $page_size = 10;
                    $result = mysqli_query($con, $sqlappCount);
                    $row = mysqli_fetch_assoc($result);
                    $total_records = $row['totalCount'];

                    $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
                    $offset = ($current_page - 1) * $page_size;
                    $total_pages = ceil($total_records / $page_size);
                    $window_size = 10;
                    $start_window = max(1, $current_page - floor($window_size / 2));
                    $end_window = min($start_window + $window_size - 1, $total_pages);
                    $sql_query = "$statement LIMIT $offset, $page_size";



                    ?>

                    <div class="card" id="filter">
                        <div class="card-block" style="overflow:auto;">
                            <form action="<? $_SERVER['PHP_SELF']; ?>" method="POST">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label>ATMID</label>
                                        <input type="text" name="atmid" value="<?= $atmid; ?>" class="form-control">
                                    </div>
                                    <div class="col-sm-12">
                                        <br />
                                        <input type="submit" name="submit" class="btn btn-primary">
                                        
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h5>Total Records: <strong class="record-count">
                                    <?= $total_records; ?>
                                </strong></h5>

                            <hr />
                            <form action="exportsites.php" method="POST">
                                <input type="hidden" name="exportSql" value="<?= $atm_sql; ?>">
                                <input type="submit" name="exportsites" class="btn btn-primary" value="Export">
                            </form>

                        </div>
                        <div class="card-block" style="overflow:auto;">
                            <table id="example" class="table table-bordered table-striped table-hover dataTable js-exportable no-footer" style="width:100%">
                                <thead>
                                    <tr class="table-primary">
                                        <th>Sr No</th>
                                        <th>ATMID</th>
                                        <th>Engineer Name</th>
                                        <th> Images </th>
                                        <th> Actions </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?
                                    $counter = ($current_page - 1) * $page_size + 1;
                                    $sql = mysqli_query($con, $sql_query);
                                    while ($sql_result = mysqli_fetch_assoc($sql)) {
                                        $id = $sql_result['id'];
                                        $siteid = $sql_result['siteid'];
                                        $atmid = $sql_result['atmid'];
                                        $created_by = $sql_result['created_by'];
                                        $engineerName = getUsername($created_by, true);
                                        $isVerify = $sql_result['isVerify'];
                                    ?>
                                        <tr>
                                            <td>
                                                <? echo $counter; ?>
                                            </td>
                                            <td class="strong">
                                                <?= $atmid; ?>
                                            </td>
                                            <td>
                                                <?= $engineerName; ?>
                                            </td>
                                            <td>
                                                <button class="view-images-btn btn btn-primary" data-atmid="<?= $atmid; ?>" data-id="<?= $id; ?>">
                                                    View Images
                                                </button>
                                            </td>
                                            <td>
                                                <a href="sealVerificationStatus.php?id=<? echo $id; ?>&&isVerfy=1&&siteid=<? echo $siteid; ?>&&atmid=<? echo $atmid; ?>">Approve</a>
                                                |
                                                <a href="sealVerificationStatus.php?id=<? echo $id; ?>&&isVerfy=2&&siteid=<? echo $siteid; ?>&&atmid=<? echo $atmid; ?>">Reject</a>
                                                <?
                                                if ($isVerify == 0) {
                                                    echo ' | Pending ';
                                                } elseif ($isVerify == 1) {
                                                    echo ' | Approved ! ';
                                                } elseif ($isVerify == 2) {
                                                    echo ' | Rejected ! ';
                                                }
                                                ?>

                                            </td>

                                        </tr>
                                    <? $counter++;
                                    } ?>
                                </tbody>
                            </table>


                        </div>







                        <?

                        $atmid = $_REQUEST['atmid'];

                        echo '<div class="pagination"><ul>';
                        if ($start_window > 1) {

                            echo "<li><a href='?page=1&&atmid=$atmid'>First</a></li>";
                            echo '<li><a href="?page=' . ($start_window - 1) . '&&atmid=' . $atmid . '">Prev</a></li>';
                        }

                        for ($i = $start_window; $i <= $end_window; $i++) {
                        ?>
                            <li class="<? if ($i == $current_page) {
                                            echo 'active';
                                        } ?>">
                                <a href="?page=<?= $i; ?>&&atmid=<?= $atmid; ?>">
                                    <?= $i; ?>
                                </a>
                            </li>

                        <? }

                        if ($end_window < $total_pages) {

                            echo '<li><a href="?page=' . ($end_window + 1) . '&&atmid=' . $atmid . '">Next</a></li>';
                            echo '<li><a href="?page=' . $total_pages . '&&atmid=' . $atmid . '">Last</a></li>';
                        }
                        echo '</ul></div>';

                        ?>




                    </div>
           



<!-- The Bootstrap modal to display images -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Images for ATM ID: <span id="atmIdSpan"></span></h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modalBody">
                <!-- Image previews will be dynamically added here -->
            </div>
        </div>
    </div>
</div>

<!-- Lightbox2 CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">

<script>
    // JavaScript to handle the button click and populate the modal with images
    const viewImagesBtns = document.querySelectorAll('.view-images-btn');
    const imageModal = document.getElementById('imageModal');
    const atmIdSpan = document.getElementById('atmIdSpan');
    const modalBody = document.getElementById('modalBody');

    viewImagesBtns.forEach(btn => {
        btn.addEventListener('click', function() {

            const id = this.dataset.id;
            const atmid = this.dataset.atmid;
            atmIdSpan.textContent = atmid;
            modalBody.innerHTML = ''; // Clear previous image previews

            // Make an AJAX request to fetch the images for the given ID
            const xhr = new XMLHttpRequest();
            xhr.open('GET', `get_images.php?id=${id}`, true);

            xhr.onload = function() {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success && response.images.length > 0) {
                        // Loop through the images and add them to the modal
                        response.images.forEach(imagePath => {
                            // Open the image in a new tab when clicked
                            const imgLink = document.createElement('a');
                            imgLink.href = imagePath;
                            imgLink.target = '_blank'; // Open in new tab

                            const img = document.createElement('img');
                            img.src = imagePath;
                            img.classList.add('image-preview');
                            img.style.maxWidth = '400px'; // Set maximum width
                            img.style.maxHeight = '400px'; // Set maximum height

                            imgLink.appendChild(img);
                            modalBody.appendChild(imgLink);
                        });
                        // Open the modal
                        $(imageModal).modal('show');
                    } else {
                        modalBody.innerHTML = '<p>No images found for this ATM ID.</p>';
                        // Open the modal
                        $(imageModal).modal('show');
                    }
                }
            };

            xhr.send();
        });
    });
</script>


<? 
}
include('../footer.php'); ?>