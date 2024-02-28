<table class="table table-striped table-bordered zero-configuration">
    <thead>
        <tr>
            <th>#</th>
            <th><?php echo e(trans('labels.name')); ?></th>
            <th><?php echo e(trans('labels.category')); ?></th>
            <th><?php echo e(trans('labels.featured')); ?></th>
            <th><?php echo e(trans('labels.status')); ?></th>
            <th><?php echo e(trans('labels.action')); ?></th>
        </tr>
    </thead>
    <tbody id="tabledetails"  data-url="<?php echo e(url('admin/item/reorder_item')); ?>">
        <?php $i = 1; ?>
        <?php $__currentLoopData = $getitem; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr class="row1" data-id="<?php echo e($item->id); ?>">
            <td><?php echo $i++; ?></td>
            <td><img <?php if($item->item_type == 1): ?> src="<?php echo e(Helper::image_path('veg.svg')); ?>" <?php else: ?> src="<?php echo e(Helper::image_path('nonveg.svg')); ?>" <?php endif; ?>
                class="item-type-img" alt=""> <?php echo e($item->item_name); ?></td>
            <td><?php echo e(@$item['category_info']->category_name); ?></td>
            <td>
                <?php if($item->is_featured == 1): ?>
                <a class="btn btn-sm btn-outline-success" <?php if(env('Environment')=='sendbox' ): ?> onclick="myFunction()"
                    <?php else: ?> onclick="StatusFeatured('<?php echo e($item->id); ?>','2','<?php echo e(URL::to('admin/item/featured')); ?>')"
                    <?php endif; ?>><i class="fa-sharp fa-solid fa-check"></i></a>
                <?php else: ?>
                <a class="btn btn-sm btn-outline-danger" <?php if(env('Environment')=='sendbox' ): ?> onclick="myFunction()"
                    <?php else: ?> onclick="StatusFeatured('<?php echo e($item->id); ?>','1','<?php echo e(URL::to('admin/item/featured')); ?>')"
                    <?php endif; ?>><i class="fa-sharp fa-solid fa-xmark"></i></a>
                <?php endif; ?>
            </td>
            <td>
                <?php if($item->item_status == 1): ?>
                <a class="btn btn-sm btn-outline-success" <?php if(env('Environment')=='sendbox' ): ?> onclick="myFunction()"
                    <?php else: ?> onclick="StatusUpdate('<?php echo e($item->id); ?>','2','<?php echo e(URL::to('admin/item/status')); ?>')" <?php endif; ?>> <i
                        class="fa-sharp fa-solid fa-check"></i></a>
                <?php else: ?>
                <a class="btn btn-sm btn-outline-danger" <?php if(env('Environment')=='sendbox' ): ?> onclick="myFunction()"
                    <?php else: ?> onclick="StatusUpdate('<?php echo e($item->id); ?>','1','<?php echo e(URL::to('admin/item/status')); ?>')" <?php endif; ?>> <i
                        class="fa-sharp fa-solid fa-xmark"></i></a>
                <?php endif; ?>
            </td>
            <td>
                <a class="btn btn-sm btn-outline-info" href="<?php echo e(URL::to('admin/item-' . $item->id)); ?>"> <i
                        class="fa-solid fa-pen-to-square"></i></a>
                <a class="btn btn-sm btn-outline-danger" <?php if(env('Environment')=='sendbox' ): ?> onclick="myFunction()"
                    <?php else: ?> onclick="Delete('<?php echo e($item->id); ?>','<?php echo e(URL::to('admin/item/delete')); ?>')" <?php endif; ?>> <i
                        class="fa fa-trash"></i></a>
            </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table><?php /**PATH /home/sup4foodan/app.supremeseafoodandsuya.com/resources/views/admin/item/table.blade.php ENDPATH**/ ?>