{{ content() }}
{{ link_to(this.view.getControllerName() | lower, 'class' : 'btn btn-primary btn-sm','style': 'margin-bottom: 30px', '<span class="glyphicon glyphicon-chevron-left"></span> &nbsp;&nbsp;Back') }}
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">New venue</h3>
    </div>
    <div class="panel-body">
        {{ form('venue/save', 'class' : 'form-horizontal', 'enctype' : 'multipart/form-data') }}
        {% if object is defined %}
            {{ form.render('id') }}
        {% endif %}
        <div class="form-group">
            <label for="name" class="col-lg-2 control-label">Name<span class="required">*</span></label>

            <div class="col-lg-10">
                {{ form.render('name', ['class' : 'form-control input-sm']) }}
            </div>
        </div>
        <div class="form-group">
            <label for="reference" class="col-lg-2 control-label">Type<span class="required">*</span></label>

            <div class="col-lg-10">
                {{ form.render('idVenueType', ['class' : 'form-control input-sm']) }}
            </div>
        </div>
        <div class="form-group">
            <label for="reference" class="col-lg-2 control-label">Address<span class="required">*</span></label>

            <div class="col-lg-10">
                {{ form.render('address', ['class' : 'form-control input-sm']) }}
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-offset-2 col-lg-10">
                {{ form.render('save') }}
            </div>
        </div>
        {{ endform() }}
    </div>
</div>
