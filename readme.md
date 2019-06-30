# Inspections API

## Requirements
The goal of this task is to create a REST API that exposes only one endpoint to post inspection data into and return the score of the inspection. Inspections are represented in a hierarchical JSON object structure, where the root element is the inspection, the first levels are always pages, and pages can contain questions or sections. Sections can contain questions and sections.

List type questions have scores (other kind of questions do not). They always point to a response set (eg: Yes:1, no:0, n/a:null). The score of a question is the selected response's value, the maximum possible score for that response set is the highest value. For multiple choice questions, the maximum possible score is the sum of all the scores in that response set, and the value is the sum of the selected responses' values. 

The maximum possible score of an inspection is the sum of all maximum possible scores of all the questions. 

The actual score of an inspecton is the sum of all the actual scores of all the questions.

Null values are different to 0 values. A `null` response value means the question was not applicable, and so the question's maximum possible value is not added to the inspection's maximum possible value. So the inspection's total maximum score depends on the actual provided responses. If a multiple choice question has only `null` values selected, the response is treated like `null`, so neither the maximum nor the actual score of that question is included in the the inspection's score.

Sections have weights. Every question's score (and maximum possible score) inside a section is multiplied (weighted) by this weight. Sections can also have sections inside them without a maximum nesting limit and nested sections also have weights that need to be taken into account.

An inspection's actual score divided by the maximum possible score represented in percentage is the inspection's score.

The returned response should be a json object with the following format:

```
{
	"total_score": 58,
	"actual_score": 41,
	"percentage": 70.68
}
```

### Requirements

The resulting API should be written in PHP, should use Laravel or Lumen (whichever is more appropriate), and should have proper test coverage.




### Assumptions.
As the JSON data contains mixed data, partially which meaning cannot be recognised right now.

- I've decided to split them into three categories: data related to challenge logic, data related to View 
(form displaying rules), unknown purpose data. First - will be operated, second and third - not.

~~~
Logic data: uuid, params, type (question, section, 
page), response, score, required.
View data: title, response_type, color, negative.
Unknown data: check_conditions_for, categories.
~~~~

- As there is no information about other parts of the system which provides Inspection service, 
so, I'm unable to assume more elegant class hierarchy which would be more suitable for the rest system components. 

- As all entities has Uuid values, I suppose they were persistent in some storage.
But I will ignore that and will create model classes without Eloquent support
