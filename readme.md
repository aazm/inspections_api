Assumptions.
As the JSON data contains mixed data, partially which meaning cannot be recognised right now.

1. I've decided to split them into three categories: data related to challenge logic, data related to View 
(form displaying rules), unknown purpose data. First - will be operated, second and third - not.

Logic data: uuid, params, type (question, section, page), response, score, required
View data: title, response_type, color, negative,
Unknown data: check_conditions_for, categories.

2. As there is no information about other parts of the system which provides Inspection service, 
so, I'm unable to assume more elegant class hierarchy which would be more suitable for the rest system components. 


