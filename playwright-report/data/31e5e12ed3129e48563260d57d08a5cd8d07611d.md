# Page snapshot

```yaml
- generic [ref=e1]:
  - generic [ref=e2]:
    - generic [ref=e3]:
      - img [ref=e5]
      - heading "Админ-панель" [level=1] [ref=e7]
      - paragraph [ref=e8]: Войдите в свой аккаунт
    - generic [ref=e10]:
      - img [ref=e11]
      - generic [ref=e13]: Неверный логин или пароль
    - generic [ref=e14]:
      - generic [ref=e15]:
        - generic [ref=e16]:
          - text: Имя пользователя
          - generic [ref=e17]: "*"
        - textbox "Имя пользователя *" [active] [ref=e18]: admin
      - generic [ref=e19]:
        - generic [ref=e20]:
          - text: Пароль
          - generic [ref=e21]: "*"
        - generic [ref=e22]:
          - textbox "Пароль *" [ref=e23]
          - button [ref=e24] [cursor=pointer]:
            - img [ref=e25] [cursor=pointer]
      - button "Вход" [ref=e28] [cursor=pointer]:
        - generic [ref=e29] [cursor=pointer]: Вход
    - generic [ref=e30]:
      - paragraph [ref=e31]: Для получения доступа обратитесь к администратору
      - link "Вернуться на сайт" [ref=e33] [cursor=pointer]:
        - /url: http://localhost
        - img [ref=e34] [cursor=pointer]
        - text: Вернуться на сайт
  - generic [ref=e36]: "Debug: ru | Default admin: root/root"
```