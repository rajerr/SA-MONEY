import { UserComponent } from './user/user.component';
import { AdminComponent } from './admin/admin.component';
import { ConnexionComponent } from './connexion/connexion.component';
import { VueComponent } from './vue/vue.component';
import { Component } from '@angular/core';
@Component({
  selector: 'app-root',
  templateUrl: 'app.component.html',
  styleUrls: ['app.component.scss'],
})
export class AppComponent {
  
  rootPage: any = VueComponent;
  // rootPage: any = ConnexionComponent;
  // rootPage: any = AdminComponent;
  // rootPage: any = UserComponent;
  constructor() {}
}
