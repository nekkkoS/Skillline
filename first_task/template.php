<table>
    <thead>
        <tr>
            <th>Category</th>
            <th>Password Name</th>
            <th>Password</th>
            <th>Created At</th>
        </tr>
    </thead>
    <tbody>
        <?foreach ($arResult['CATEGORIES'] as $category):?>
            <tr>
                <td><?=$category['NAME']?></td>
                <td colspan="3"></td>
            </tr>
            <?foreach ($arResult['PASSWORDS'] as $password):?>
                <?if ($password['CATEGORY_ID'] == $category['ID']):?>
                    <tr>
                        <td></td>
                        <td><?=$password['NAME']?></td>
                        <td><?=$password['PASSWORD']?></td>
                        <td><?=$password['CREATED_AT']->toString()?></td>
                    </tr>
                <?endif;?>
            <?endforeach?>
        <?endforeach?>
    </tbody>
</table>
