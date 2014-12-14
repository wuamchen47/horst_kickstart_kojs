<div class="col_12" data-bind="event: { load: loadData() }">
    <table data-bind="visible: news().length > 0">
        <thead>
            <tr>
                <th>Name</th>
                <th>fulldate</th>
                <th>avatar</th>
                <th>Comment</th>
                <th>link</th>
            </tr>
        </thead>
        <tbody data-bind="foreach: news">
            <tr>
                <td>
                    <span data-bind="text: name"></span>
                </td>
                <td>
                    <span data-bind="text: fulldate"></span>
                </td>
                <td data-bind="html: imgavatar"></td>
                <td data-bind="html: btnlink"></td>
                <td>
                    <span data-bind="text: comment"></span>
                </td>
            </tr>
        </tbody>
    </table>
</div>

