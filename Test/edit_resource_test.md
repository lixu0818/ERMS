1. 'Delete' a 'in use' resource. Error message should be poped out.
2. 'Delete' a resource that is not in use/repair/request. It should be allowed and record disappear from the list and resource table. Also confirm that the deletion is recorded in the Resource Audit table.
3. 'Update' a resource. Modify an attribute in the update page. Should expect a success message. Confirm the attribute is updated in the database, and the modification is recorded in the audit table as well.
4. Audit tables are also established for request, deploy_schedule, repair_schedule tables to track history.