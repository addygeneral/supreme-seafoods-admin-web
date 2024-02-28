<table class="table table-striped table-bordered zero-configuration">
    <thead>
        <tr>
            <th>#</th>
            <th><?php echo e(trans('labels.subcategory')); ?></th>
            <th><?php echo e(trans('labels.category')); ?></th>
            <th><?php echo e(trans('labels.status')); ?></th>
            <th><?php echo e(trans('labels.action')); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 1; ?>
        <?php $__currentLoopData = $getsubcategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr id="dataid<?php echo e($category->id); ?>">
            <td><?php echo $i++; ?></td>
            <td><?php echo e($category->subcategory_name); ?></td>
            <td><?php echo e(@$category['category_info']->category_name); ?></td>
            <td>
                <?php if($category->is_available == 1): ?>
                    <a class="btn btn-sm btn-outline-success" <?php if(env('Environment')=='sendbox'): ?> onclick="myFunction()" <?php else: ?> onclick="StatusUpdate('<?php echo e($category->id); ?>','2','<?php echo e(URL::to('admin/sub-category/status')); ?>')" <?php endif; ?>><i class="fa-sharp fa-solid fa-check"></i></a>
                <?php else: ?>
                    <a class="btn btn-sm btn-outline-danger" <?php if(env('Environment')=='sendbox'): ?> onclick="myFunction()" <?php else: ?> onclick="StatusUpdate('<?php echo e($category->id); ?>','1','<?php echo e(URL::to('admin/sub-category/status')); ?>')" <?php endif; ?>><i class="fa-sharp fa-solid fa-xmark"></i></a>
                <?php endif; ?>
            </td>
            <td>
                <a class="btn btn-sm btn-outline-info" href="<?php echo e(URL::to('admin/sub-category-'.$category->id)); ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                <a class="btn btn-sm btn-outline-danger" <?php if(env('Environment')=='sendbox'): ?> onclick="myFunction()" <?php else: ?> onclick="Delete('<?php echo e($category->id); ?>','<?php echo e(URL::to('admin/sub-category/delete')); ?>')" <?php endif; ?>><i class="fa fa-trash"></i></a>
            </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table><?php /**PATH /home/sup4foodan/app.supremeseafoodandsuya.com/resources/views/admin/subcategory/table.blade.php ENDPATH**/ ?>