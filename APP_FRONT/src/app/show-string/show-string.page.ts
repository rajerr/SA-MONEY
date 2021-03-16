import { Component, ContentChild, OnInit } from '@angular/core';
import { IonInput } from '@ionic/angular';

@Component({
  selector: 'app-show-string',
  templateUrl: './show-string.page.html',
  styleUrls: ['./show-string.page.scss'],
})
export class ShowStringPage implements OnInit {

  showString = false
  @ContentChild(IonInput) input: IonInput;
  constructor() { }

  toggleShow() {
    this.showString = !this.showString;
    this.input.type = this.showString ? 'text' : 'password';
  }

  ngOnInit() {
  }

}
