{{ content() }}
{{ link_to(this.view.getControllerName() | lower ~ '/new', 'class' : 'btn btn-primary btn-sm','style': 'margin-bottom: 30px', '<span class="glyphicon glyphicon-plus"></span> &nbsp;&nbsp;Add new') }}
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title"><span class="glyphicon glyphicon-list"></span>&nbsp;Venues</h3>
    </div>
    <div class="panel-body">
        <table class="table table-condensed table-hover">
            <tr>
                {% for key, value in grid %}
                    {% if value['order'] is defined %}
                        <th class="sorting" data-order-by="{{ key }}" data-order-way="">{{ value['title'] }}</th>
                    {% else %}
                        <th class="">{{ value['title'] }}</th>
                    {% endif %}
                {% endfor %}
                <th>
                    Actions
                </th>
            </tr>
            {% if items is iterable %}
                {% for item in items %}
                    <tr>
                        <td>{{ item.getId() }}</td>
                        <td>{{ item.getVenueType().getName() }}</td>
                        <td>{{ item.getName() }}</td>
                        <td>{{ item.getAddress() }}</td>
                        <td>{{ item.getDateAdd() }}</td>
                        <td class="text-center">
                            {{ link_to(this.view.getControllerName() | lower ~ '/edit/' ~ item.getId(), '<i class="fa fa-edit"></i>', 'title' : 'Edit entry', 'data-toggle' : 'tooltip', 'data-placement' : 'bottom') }}
                            &nbsp;
                            {{ link_to(this.view.getControllerName() | lower ~ '/delete/' ~ item.getId(), '<i class="fa fa-trash-o"></i>', 'title' : 'Delete entry', 'data-toggle' : 'tooltip', 'data-placement' : 'bottom', 'onclick' : "return confirm('Are you sure you want to delete this entry?')") }}
                        </td>
                    </tr>
                {% endfor %}
            {% endif %}
        </table>
    </div>
</div>