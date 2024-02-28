<table class="table table-striped table-bordered zero-configuration">
    <thead>
        <tr>
            <th>#</th>
            <th><?php echo e(trans('labels.image')); ?></th>
            <th><?php echo e(trans('labels.title')); ?></th>
            <th><?php echo e(trans('labels.category')); ?></th>
            <th><?php echo e(trans('labels.item')); ?></th>
            <th><?php echo e(trans('labels.description')); ?></th>
            <th><?php echo e(trans('labels.status')); ?></th>
            <th><?php echo e(trans('labels.action')); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 1; ?>
        <?php $__currentLoopData = $getslider; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr id="dataid<?php echo e($slider->id); ?>">
            <td><?php echo $i++; ?></td>
            <td><img src='<?php echo e(Helper::image_path($slider->image)); ?>' class='img-fluid rounded hw-50'></td>
            <td><?php echo e($slider->title); ?></td>
            <td><?php if($slider->type == "1"): ?> <?php echo e(@$slider['category_info']->category_name); ?> <?php else: ?> -- <?php endif; ?></td>
            <td><?php if($slider->type == "2"): ?> <?php echo e(@$slider['item_info']->item_name); ?> <?php else: ?> -- <?php endif; ?></td>
            <td><?php echo e($slider->description); ?></td>
            <td>
                <?php if($slider->is_available == 1): ?>
                    <a class="btn btn-sm btn-outline-success" <?php if(env('Environment')=='sendbox'): ?> onclick="myFunction()" <?php else: ?> onclick="StatusUpdate('<?php echo e($slider->id); ?>','2','<?php echo e(URL::to('admin/slider/status')); ?>')" <?php endif; ?>><i class="fa-sharp fa-solid fa-check"></i></a>
                <?php else: ?>
                    <a class="btn btn-sm btn-outline-danger" <?php if(env('Environment')=='sendbox'): ?> onclick="myFunction()" <?php else: ?> onclick="StatusUpdate('<?php echo e($slider->id); ?>','1','<?php echo e(URL::to('admin/slider/status')); ?>')" <?php endif; ?>><i class="fa-sharp fa-solid fa-xmark"></i></a>
                <?php endif; ?>
            </td>
            <td>
                <a class="btn btn-sm btn-outline-info" href="<?php echo e(URL::to('admin/slider-'.$slider->id)); ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                <a class="btn btn-sm btn-outline-danger" href="javascript:void(0)" <?php if(env('Environment')=='sendbox'): ?> onclick="myFunction()" <?php else: ?> onclick="DeleteData('<?php echo e($slider->id); ?>','<?php echo e(URL::to('admin/slider/destroy')); ?>')" <?php endif; ?>><i class="fa fa-trash"></i></a>
            </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table><?php /**PATH /home/sup4foodan/app.supremeseafoodandsuya.com/resources/views/admin/slider/slidertable.blade.php ENDPATH**/ ?>