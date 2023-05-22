# Admin panel documentation

Coming soon more documentation on this package

## Course - Additional Settings

`boolean (default: false)` showInCourseAdditionalSettings-**public**

If you want to be able to mark course as **public**, which means **free** of charge, you need to set value of this setting to `true`. It's `false` by default, because that feature isn't use often.

-   :white_check_mark: Here's example of this setting enabled:
    ![](./docs/settings/setting-additional-public-true.png)

    Then, in course attributes you should see this option available:

    ![](./docs/settings/setting-additional-public.png)

## Templates - Hide tabs

`boolean (default: false)` hideTemplateTab-**email**

`boolean (default: false)` hideTemplateTab-**sms**

By default all tabs are shown.

![](./docs/settings/templates-tabs-default.png)

Let's hide **email** and **sms** tabs.

![](./docs/settings/templates-tabs-disabled.png)

Result:

![](./docs/settings/templates-tabs-hidden.png)
