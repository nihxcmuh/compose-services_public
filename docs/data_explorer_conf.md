- [etlMapping.yaml](#etlmappingyaml)
    - [Configs which need to match `guppy_config.json`](#configs-which-need-to-match-guppy_configjson)
      - [Type](#type)
      - [Properties](#properties)
    - [The aggregation ETL ("aggregator" mapping)](#the-aggregation-etl-aggregator-mapping)
    - [The injecting ETL ("collector" mapping)](#the-injecting-etl-collector-mapping)
- [gitops.json](#gitopsjson)

# etlMapping.yaml
[code](../patch/Secrets_biobank/etlMapping.yaml)

Official Document: https://github.com/uc-cdis/tube/blob/master/docs/configuration_file.md

### Configs which need to match `guppy_config.json`
It is worth to mentioning that the index and type in `guppy_config.json` need to be matched with the index in `etlMapping.yml`.

name: ElasticSearch index name, match to `index` in `guppy_config.json`  
doc_type: document type - used to query the index, match to `type`  in `guppy_config.json`
```yaml
mappings:
  - name: etl
    doc_type: case
    type: aggregator
    root: case # if "aggregator": root node in the input database
    # config...
  - name: file 
    doc_type: file
    type: collector
    root: None
    category: data_file # if "collector": node category to collect properties from. Default: "data_file"
    # config...
```

```json
// guppy_config.json
{
    "indices": [
        {
            "index": "etl", // match to 'name'
            "type": "case" // match to 'doc_type'
        },
        {
            "index": "file",
            "type": "file"
        },
    ],
}
```

####  Type
type: aggregator or collector  

We choose the later two approaches to implement in Tube. They are implemented as two mapping syntaxes:

1. The "aggregation" syntax (mapping type: aggregator) allows to pre-compute and integrate data from multiple nodes in the original dataset to an individual one in the target dataset.
2. The "injection" syntax (mapping type: collector) allows to embed some fields in a high level node to lower level nodes to reduce the time needed to join.
```yaml
mappings:
  - name: etl
    doc_type: case
    type: aggregator
    root: case
``` 

#### Properties
props: Must match to the properties in DD. Please don't put any `name` which is not a property of the setting node. Here is an example of `case` node.
```yaml
mappings:
  - name: etl
    # other setting
    root: case
    props:
      - name: submitter_id
      - name: project_id
      - name: disease_type
      - name: primary_site
```

### The aggregation ETL ("aggregator" mapping)

flatten_props: The properties of the child node of the setting node.  For example `demographics` is a child node of `case`.
```yaml
mappings:
  - name: etl
    # other setting
    root: case
    flatten_props:
      - path: demographics # The child node name
      props:
          - name: gender
          value_mappings: # Mapping values to human friendly text
              - female: F
              - male: M
          - name: race
          value_mappings:
              - american indian or alaskan native: Indian
          - name: ethnicity
          - name: year_of_birth
          - name: year_of_death
```

aggregated_props: aggregated properties. Only supported  `aggregator` type.
```yaml
mappings:
  - name: etl
    doc_type: case
    type: aggregator
    root: case
    aggregated_props:
      - name: _ct_series_file_count # Property name
        path: imaging_studies.ct_series_files # Path from the setting node
        fn: count # function
      - name: _cr_series_file_count
        path: imaging_studies.cr_series_files
        fn: count      
```

joining_props: The properties of child node which you want to join. Only supported  `aggregator` type.
```yaml
mappings:
  - name: etl
    doc_type: case
    type: aggregator
    root: case
    joining_props:
      - index: file
        join_on: _case_id
        props:
          - name: data_format
            src: data_format
            fn: set
          - name: data_type
            src: data_type
            fn: set
          - name: _file_id
            src: file_id
            fn: set
      - index: imaging_data_file
        join_on: _case_id
        props:
          - name: object_id
            src: object_id
            fn: set
          - name: data_format
            src: data_format
            fn: set
          - name: data_type
            src: data_type
            fn: set
          - name: data_category
            src: data_category
            fn: set

```

parent_props:  The properties of parent node. Only supported  `aggregator` type.
```yaml
mappings:
  - name: midrc_imaging_study
    doc_type: imaging_study
    type: aggregator
    root: imaging_study
    parent_props:
      - path: cases[sex,race,age_at_index,index_event,zip,covid19_positive,ethnicity].experiments[experiments_submitter_id:submitter_id]
```
### The injecting ETL ("collector" mapping)

injecting_props: The properties of parent node which you want to inject. Only supported  `collector` type.
```yaml
mappings:
  - name: midrc_imaging_data_file
    doc_type: imaging_data_file
    type: collector
    category: imaging_data_file
    injecting_props:
      experiment:
        props:
          - name: _experiment_id
            src: id
            fn: set
      case:
        props:
          - name: _case_id
            src: id
            fn: set
          - name: age_at_index
            src: age_at_index
            fn: set
      imaging_study:
        props:
          - name: _imaging_study_id
            src: id
            fn: set
          - name: age_at_imaging
            src: age_at_imaging
            fn: set
          
```

# gitops.json
[code](../patch/Secrets_biobank/gitops.json)