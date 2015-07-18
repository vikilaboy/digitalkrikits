<div class="header">
    <div class="navigation-wrapper">
        <div class="navigation clearfix-normal">
            <div class="menu-main-container">
                <ul id="menu-main" class="nav">
                    <li class="menu-item menu-item-type-custom menu-item-object-custom">
                        {% if this.view.getControllerName() == 'venue' %}
                            {{ link_to('venue', 'class' : 'active', 'Venues') }}
                        {% else %}
                            {{ link_to('venue', 'Venues') }}
                        {% endif %}
                    </li>
                    <li class="menu-item menu-item-type-custom menu-item-object-custom">
                        {% if this.view.getControllerName() == 'index' %}
                            {{ link_to('', 'class' : 'active', 'Home') }}
                        {% else %}
                            {{ link_to('', 'Home') }}
                        {% endif %}
                    </li>
                </ul>
            </div>
        </div>
        <!-- /.navigation -->
    </div>
    <h3 class="text-muted">{{ link_to('','DigitalKrikits') }} </h3>
</div>